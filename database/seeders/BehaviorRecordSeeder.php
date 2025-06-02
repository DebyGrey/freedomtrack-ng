<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inmate;
use App\Models\BehaviorRecord;
use Carbon\Carbon;

class BehaviorRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inmates = Inmate::all();

        $positiveActivities = [
            'Helped new inmate settle in',
            'Completed extra work duty',
            'Mentored struggling peer',
            'Participated in community service',
            'Showed leadership in group activity',
            'Assisted staff with facility maintenance',
            'Mediated conflict between inmates',
            'Volunteered for kitchen duty',
            'Helped organize recreational activities',
            'Demonstrated excellent behavior during visit',
            'Participated in religious service',
            'Completed additional educational assignment',
            'Showed improvement in anger management',
            'Helped maintain facility cleanliness',
            'Participated in peer counseling session',
        ];

        $neutralActivities = [
            'Regular cell inspection',
            'Routine medical checkup',
            'Standard meal service',
            'Regular exercise period',
            'Scheduled program attendance',
            'Normal visitor session',
            'Routine security check',
            'Standard work assignment',
            'Regular counseling session',
            'Scheduled court appearance',
        ];

        $negativeActivities = [
            'Minor altercation with peer',
            'Late for scheduled activity',
            'Verbal disagreement with staff',
            'Missed mandatory program session',
            'Minor rule violation',
            'Disruptive behavior during meal',
            'Failure to follow instructions',
            'Inappropriate language use',
            'Minor contraband possession',
            'Unexcused absence from work duty',
            'Disrespectful behavior',
            'Minor property damage',
        ];

        $behaviorRecords = [];

        foreach ($inmates as $inmate) {
            // Generate 5-15 behavior records per inmate
            $numRecords = rand(5, 15);

            for ($i = 0; $i < $numRecords; $i++) {
                // Determine behavior type (70% positive, 20% neutral, 10% negative)
                $rand = rand(1, 100);
                if ($rand <= 70) {
                    $type = 'positive';
                    $description = $positiveActivities[array_rand($positiveActivities)];
                    $points = rand(3, 10);
                } elseif ($rand <= 90) {
                    $type = 'neutral';
                    $description = $neutralActivities[array_rand($neutralActivities)];
                    $points = 0;
                } else {
                    $type = 'negative';
                    $description = $negativeActivities[array_rand($negativeActivities)];
                    $points = rand(-5, -1);
                }

                // Generate random date within the last year
                $date = Carbon::now()->subDays(rand(1, 365));

                $behaviorRecords[] = [
                    'inmate_id' => $inmate->id,
                    'date' => $date,
                    'type' => $type,
                    'description' => $description,
                    'points' => $points,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
        }

        // Insert in chunks
        $chunks = array_chunk($behaviorRecords, 100);
        foreach ($chunks as $chunk) {
            BehaviorRecord::insert($chunk);
        }
    }
}
