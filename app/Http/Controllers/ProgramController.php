<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Inmate;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('instructor', 'like', "%{$search}%");
            });
        }

        $programs = $query->get();

        // Filter by status for tabs
        $activePrograms = $programs->where('status', 'active');
        $upcomingPrograms = $programs->where('status', 'upcoming');

        return view('programs.index', compact('programs', 'activePrograms', 'upcomingPrograms'));
    }

    public function show(Program $program)
    {
        // Load participants
        $program->load('inmates');

        return view('programs.show', compact('program'));
    }

    public function create()
    {
        $categories = ['vocational', 'therapy', 'education'];

        return view('programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:vocational,therapy,education',
            'duration' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'instructor' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string|in:active,upcoming,completed',
            'description' => 'required|string',
        ]);

        $program = Program::create($validated);

        return redirect()->route('programs.show', $program)
            ->with('success', 'Program created successfully.');
    }

    public function edit(Program $program)
    {
        $categories = ['vocational', 'therapy', 'education'];

        return view('programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:vocational,therapy,education',
            'duration' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'instructor' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string|in:active,upcoming,completed',
            'description' => 'required|string',
        ]);

        $program->update($validated);

        return redirect()->route('programs.show', $program)
            ->with('success', 'Program updated successfully.');
    }

    public function enroll(Request $request, Program $program)
    {
        $validated = $request->validate([
            'inmate_ids' => 'required|array',
            'inmate_ids.*' => 'exists:inmates,id',
        ]);

        $program->inmates()->attach($validated['inmate_ids']);

        return redirect()->route('programs.show', $program)
            ->with('success', 'Inmates enrolled successfully.');
    }
}
