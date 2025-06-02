<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inmate;
use App\Models\Activity;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inmates = Inmate::all();

        $activities = [
            // Program-related activities
            ['activity' => 'Completed Carpentry Level 2', 'type' => 'program'],
            ['activity' => 'Started Financial Literacy Workshop', 'type' => 'program'],
            ['activity' => 'Graduated from Computer Literacy Program', 'type' => 'program'],
            ['activity' => 'Enrolled in Anger Management Therapy', 'type' => 'program'],
            ['activity' => 'Completed Welding Certification', 'type' => 'program'],
            ['activity' => 'Finished Tailoring Course', 'type' => 'program'],
            ['activity' => 'Passed Auto Mechanics Assessment', 'type' => 'program'],
            ['activity' => 'Completed Substance Abuse Counseling', 'type' => 'program'],

            // Parole-related activities
            ['activity' => 'Parole hearing scheduled', 'type' => 'parole'],
            ['activity' => 'Parole application submitted', 'type' => 'parole'],
            ['activity' => 'Parole review completed', 'type' => 'parole'],
            ['activity' => 'Parole eligibility assessment', 'type' => 'parole'],
            ['activity' => 'Parole board interview conducted', 'type' => 'parole'],

            // Therapy-related activities
            ['activity' => 'Counseling session attended', 'type' => 'therapy'],
            ['activity' => 'Group therapy participation', 'type' => 'therapy'],
            ['activity' => 'Mental health evaluation completed', 'type' => 'therapy'],
            ['activity' => 'Family counseling session', 'type' => 'therapy'],
            ['activity' => 'Trauma recovery session attended', 'type' => 'therapy'],

            // Education-related activities
            ['activity' => 'Educational assessment passed', 'type' => 'education'],
            ['activity' => 'Literacy test completed', 'type' => 'education'],
            ['activity' => 'Mathematics course finished', 'type' => 'education'],
            ['activity' => 'English proficiency exam passed', 'type' => 'education'],
            ['activity' => 'Computer skills certification earned', 'type' => 'education'],
        ];

        $activityRecords = [];

        foreach ($inmates as $inmate) {
            // Generate 3-8 activities per inmate
            $numActivities = rand(3, 8);
            $selectedActivities = collect($activities)->random($numActivities);

            foreach ($selectedActivities as $activity) {
                // Generate random timestamp within the last 30 days
                $createdAt = Carbon::now()->subDays(rand(1, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

                $activityRecords[] = [
                    'inmate_id' => $inmate->id,
                    'activity' => $activity['activity'],
                    'type' => $activity['type'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
        }

        // Sort by created_at descending to show most recent first
        usort($activityRecords, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        // Insert in chunks
        $chunks = array_chunk($activityRecords, 100);
        foreach ($chunks as $chunk) {
            Activity::insert($chunk);
        }
    }
}
