<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Inmate;
use App\Models\Program;
use Carbon\Carbon;

class InmateProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inmates = Inmate::all();
        $programs = Program::all();

        $enrollments = [];

        foreach ($inmates as $inmate) {
            // Each inmate participates in 2-6 programs
            $numPrograms = rand(2, 6);
            $selectedPrograms = $programs->random($numPrograms);

            foreach ($selectedPrograms as $program) {
                // Determine progress based on program status and random factors
                $progress = 0;
                $completionDate = null;
                $certification = null;

                if ($program->status === 'completed') {
                    $progress = rand(70, 100);
                    if ($progress >= 80) {
                        $completionDate = $program->end_date;
                        $certification = $this->getCertification($program->category, $program->name);
                    }
                } elseif ($program->status === 'active') {
                    // Calculate progress based on time elapsed
                    $totalDuration = $program->start_date->diffInDays($program->end_date);
                    $elapsed = $program->start_date->diffInDays(Carbon::now());
                    $timeProgress = min(100, ($elapsed / $totalDuration) * 100);

                    // Add some randomness
                    $progress = max(0, min(100, $timeProgress + rand(-20, 20)));

                    if ($progress >= 100) {
                        $progress = 100;
                        $completionDate = Carbon::now();
                        $certification = $this->getCertification($program->category, $program->name);
                    }
                } else {
                    // Upcoming programs
                    $progress = 0;
                }

                $enrollments[] = [
                    'inmate_id' => $inmate->id,
                    'program_id' => $program->id,
                    'progress' => $progress,
                    'completion_date' => $completionDate,
                    'certification' => $certification??false,
                    'enrollment_date' => $program->start_date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert enrollments in chunks to avoid memory issues
        $chunks = array_chunk($enrollments, 100);
        foreach ($chunks as $chunk) {
            DB::table('inmate_program')->insert($chunk);
        }
    }

    private function getCertification($category, $programName)
    {
        $certifications = [
            'vocational' => [
                'Basic Certificate',
                'Intermediate Certificate',
                'Advanced Certificate',
                'Professional Certificate',
            ],
            'education' => [
                'Completion Certificate',
                'Achievement Certificate',
                'Proficiency Certificate',
            ],
            'therapy' => [
                'Completion Certificate',
                'Participation Certificate',
                'Progress Certificate',
            ],
        ];

        $categoryOptions = $certifications[$category] ?? ['Completion Certificate'];
        return $categoryOptions[array_rand($categoryOptions)];
    }
}
