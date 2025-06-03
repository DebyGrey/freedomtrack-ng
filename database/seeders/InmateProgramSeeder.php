<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Inmate;
use App\Models\Program;
use Carbon\Carbon;

class InmateProgramSeeder extends Seeder
{
    public function run(): void
    {
        $inmates = Inmate::all();
        $programs = Program::all();

        $enrollments = [];

        foreach ($inmates as $inmate) {
            $numPrograms = rand(2, 6);
            $selectedPrograms = $programs->random($numPrograms);

            foreach ($selectedPrograms as $program) {
                $progress = 0;
                $completionDate = null;
                $certification = null;

                $startDate = $program->start_date instanceof Carbon ? $program->start_date : Carbon::parse($program->start_date);
                $endDate = $program->end_date instanceof Carbon ? $program->end_date : Carbon::parse($program->end_date);

                if ($program->status === 'completed') {
                    $progress = rand(70, 100);
                    if ($progress >= 80) {
                        $completionDate = $endDate;
                        $certification = $this->getCertification($program->category, $program->name);
                    }
                } elseif ($program->status === 'active') {
                    $totalDuration = $startDate->diffInDays($endDate);
                    if ($totalDuration === 0) {
                        $timeProgress = 100;
                    } else {
                        $elapsed = $startDate->diffInDays(Carbon::now());
                        $timeProgress = min(100, ($elapsed / $totalDuration) * 100);
                    }

                    $progress = max(0, min(100, $timeProgress + rand(-20, 20)));

                    if ($progress >= 100) {
                        $progress = 100;
                        $completionDate = Carbon::now();
                        $certification = $this->getCertification($program->category, $program->name);
                    }
                }

                $enrollments[] = [
                    'inmate_id' => $inmate->id,
                    'program_id' => $program->id,
                    'progress' => $progress,
                    'completion_date' => $completionDate,
                    'certification' => $certification ?? null,
                    'enrollment_date' => $startDate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $chunks = array_chunk($enrollments, 100);
        foreach ($chunks as $chunk) {
            DB::table('inmate_program')->insert($chunk);
            // Or for idempotent seeding:
            // DB::table('inmate_program')->upsert($chunk, ['inmate_id', 'program_id'], ['progress', 'completion_date', 'certification', 'enrollment_date', 'updated_at']);
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
// This seeder populates the inmate_program table with randomized enrollments