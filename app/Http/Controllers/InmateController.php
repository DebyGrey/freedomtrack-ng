<?php

namespace App\Http\Controllers;

use App\Models\Inmate;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InmateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inmate::with(['programs']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('inmate_id', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $inmates = $query->paginate(20);

        return view('inmates.index', compact('inmates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inmates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'inmate_id' => 'required|string|unique:inmates,inmate_id',
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|string|in:male,female',
            'crime_category' => 'required|string',
            'sentence_length' => 'required|string',
            'admission_date' => 'required|date',
            'release_date' => 'nullable|date|after:admission_date',
            'parole_date' => 'nullable|date|after:admission_date',
            'behavior_score' => 'required|integer|min:1|max:10',
            'readiness_score' => 'required|integer|min:0|max:100',
            'status' => 'required|string|in:active,parole,released',
        ]);

        $inmate = Inmate::create($validated);

        return redirect()->route('inmates.show', $inmate)
            ->with('success', 'Inmate created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inmate $inmate)
    {
        // Load inmate with programs and pivot data
        $inmate->load(['programs' => function ($query) {
            $query->withPivot(['status', 'progress', 'enrollment_date', 'completion_date', 'certification']);
        }]);

        // Get available programs for enrollment (programs the inmate is not already enrolled in)
        $availablePrograms = Program::whereNotIn('id', $inmate->programs->pluck('id'))
            ->where('status', 'active')
            ->get();

        // Sample assessment scores (in a real app, these would come from a separate assessment table)
        $assessmentScores = [
            'education' => 75,
            'vocational' => 68,
            'mental_health' => 82,
            'social' => 71,
        ];

        return view('inmates.show', compact('inmate', 'availablePrograms', 'assessmentScores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inmate $inmate)
    {
        return view('inmates.edit', compact('inmate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inmate $inmate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|string|in:male,female',
            'crime_category' => 'required|string',
            'sentence_length' => 'required|string',
            'admission_date' => 'required|date',
            'release_date' => 'nullable|date|after:admission_date',
            'parole_date' => 'nullable|date|after:admission_date',
            'behavior_score' => 'required|integer|min:1|max:10',
            'readiness_score' => 'required|integer|min:0|max:100',
            'status' => 'required|string|in:active,parole,released',
        ]);

        $inmate->update($validated);

        return redirect()->route('inmates.show', $inmate)
            ->with('success', 'Inmate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inmate $inmate)
    {
        $inmate->delete();

        return redirect()->route('inmates.index')
            ->with('success', 'Inmate deleted successfully.');
    }

    /**
     * Enroll inmate in a program
     */
    public function enroll(Request $request, Inmate $inmate)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'enrollment_date' => 'required|date',
        ]);

        // Check if inmate is already enrolled in this program
        if ($inmate->programs()->where('program_id', $validated['program_id'])->exists()) {
            return redirect()->route('inmates.show', $inmate)
                ->with('error', 'Inmate is already enrolled in this program.');
        }

        // Enroll the inmate
        $inmate->programs()->attach($validated['program_id'], [
            'status' => 'active',
            'progress' => 0,
            'enrollment_date' => $validated['enrollment_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('inmates.show', $inmate)
            ->with('success', 'Inmate enrolled in program successfully.');
    }

    /**
     * Update program progress for an inmate
     */
    public function updateProgress(Request $request, Inmate $inmate)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'progress' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if inmate is enrolled in this program
        $enrollment = $inmate->programs()->where('program_id', $validated['program_id'])->first();

        if (!$enrollment) {
            return redirect()->route('inmates.show', $inmate)
                ->with('error', 'Inmate is not enrolled in this program.');
        }

        // Update progress
        $updateData = [
            'progress' => $validated['progress'],
            'updated_at' => now(),
        ];

        // If progress is 100%, mark as completed
        if ($validated['progress'] == 100) {
            $updateData['status'] = 'completed';
            $updateData['completion_date'] = now();
            $updateData['certification'] = true; // Assume certification is granted on completion
        }

        $inmate->programs()->updateExistingPivot($validated['program_id'], $updateData);

        // Update inmate's overall readiness score based on completed programs
        $this->updateReadinessScore($inmate);

        return redirect()->route('inmates.show', $inmate)
            ->with('success', 'Program progress updated successfully.');
    }

    /**
     * Submit a behavior report for an inmate
     */
    public function behaviorReport(Request $request, Inmate $inmate)
    {
        $validated = $request->validate([
            'behavior_type' => 'required|string|in:positive,negative,incident',
            'behavior_score' => 'required|integer|min:1|max:10',
            'description' => 'required|string|max:1000',
            'report_date' => 'required|date',
        ]);

        // Update the inmate's behavior score
        $inmate->update([
            'behavior_score' => $validated['behavior_score']
        ]);

        // In a real application, you would also store the behavior report in a separate table
        // For now, we'll just update the score and show a success message

        // Update readiness score based on new behavior score
        $this->updateReadinessScore($inmate);

        return redirect()->route('inmates.show', $inmate)
            ->with('success', 'Behavior report submitted successfully.');
    }

    /**
     * Calculate and update inmate's readiness score
     */
    private function updateReadinessScore(Inmate $inmate)
    {
        // Reload the inmate with programs to get fresh data
        $inmate->load('programs');

        // Calculate readiness score based on:
        // - Behavior score (40% weight)
        // - Program completion (40% weight)
        // - Time served (20% weight)

        $behaviorWeight = 0.4;
        $programWeight = 0.4;
        $timeWeight = 0.2;

        // Behavior score (convert from 1-10 to 0-100 scale)
        $behaviorScore = (($inmate->behavior_score - 1) / 9) * 100;

        // Program completion score
        $totalPrograms = $inmate->programs->count();
        $completedPrograms = $inmate->programs->where('pivot.status', 'completed')->count();
        $programScore = $totalPrograms > 0 ? ($completedPrograms / $totalPrograms) * 100 : 0;

        // Time served score (assuming longer time served = higher readiness, capped at 100%)
        $monthsServed = $inmate->admission_date->diffInMonths(now());
        $timeScore = min(($monthsServed / 24) * 100, 100); // 24 months = 100%

        // Calculate weighted average
        $readinessScore = round(
            ($behaviorScore * $behaviorWeight) +
                ($programScore * $programWeight) +
                ($timeScore * $timeWeight)
        );

        // Update the inmate's readiness score
        $inmate->update(['readiness_score' => $readinessScore]);
    }
}
