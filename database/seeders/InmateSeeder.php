<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Inmate;
use Carbon\Carbon;

class InmateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            'Lagos Correctional Center',
            'Abuja Correctional Facility',
            'Port Harcourt Correctional Center',
            'Kano Correctional Facility',
            'Ibadan Correctional Center',
            'Enugu Correctional Facility',
        ];

        $offenses = [
            'Armed Robbery',
            'Fraud',
            'Drug Trafficking',
            'Assault',
            'Theft',
            'Cybercrime',
            'Embezzlement',
            'Kidnapping',
            'Burglary',
            'Money Laundering',
        ];

        $firstNames = [
            'Adebayo',
            'Chidi',
            'Fatima',
            'Ibrahim',
            'Kemi',
            'Olumide',
            'Aisha',
            'Emeka',
            'Blessing',
            'Yusuf',
            'Grace',
            'Tunde',
            'Amina',
            'Chioma',
            'Musa',
            'Folake',
            'Uche',
            'Zainab',
            'Biodun',
            'Hauwa',
            'Segun',
            'Ngozi',
            'Aliyu',
            'Funmi',
            'Ikechukwu',
            'Halima',
            'Babatunde',
            'Comfort',
            'Suleiman',
            'Patience',
        ];

        $lastNames = [
            'Johnson',
            'Okafor',
            'Hassan',
            'Adeyemi',
            'Musa',
            'Eze',
            'Bello',
            'Okoro',
            'Abdullahi',
            'Ogundimu',
            'Yakubu',
            'Nwosu',
            'Garba',
            'Adebisi',
            'Usman',
            'Chukwu',
            'Sani',
            'Okonkwo',
            'Danjuma',
            'Ogbonna',
            'Lawal',
            'Onyeka',
            'Shehu',
            'Nnamdi',
            'Yaro',
            'Chikezie',
            'Audu',
            'Emeka',
            'Tanko',
            'Obinna',
        ];

        $relationships = ['Mother', 'Father', 'Sister', 'Brother', 'Spouse', 'Uncle', 'Aunt', 'Cousin'];

        $inmates = [];

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;

            $age = rand(18, 65);
            $dateOfBirth = Carbon::now()->subYears($age)->subDays(rand(0, 365));
            $admissionDate = Carbon::now()->subMonths(rand(6, 60));
            $sentenceYears = rand(1, 10);
            $sentenceEndDate = $admissionDate->copy()->addYears($sentenceYears);

            // Calculate parole eligibility (typically after serving 1/3 of sentence)
            $paroleEligibleDate = $admissionDate->copy()->addYears(ceil($sentenceYears / 3));
            $isParoleEligible = Carbon::now()->gte($paroleEligibleDate);

            // Generate readiness score based on time served and random factors
            $timeServed = $admissionDate->diffInMonths(Carbon::now());
            $baseScore = min(($timeServed / ($sentenceYears * 12)) * 60, 60); // Base score from time served
            $programBonus = rand(0, 30); // Bonus from programs
            $behaviorBonus = rand(-10, 20); // Behavior adjustment
            $readinessScore = max(0, min(100, $baseScore + $programBonus + $behaviorBonus));

            $inmates[] = [
                'uuid' => (string) Str::uuid(),
                'inmate_id' => 'INM' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => $name,
                'age' => $age,
                'date_of_birth' => $dateOfBirth,
                'facility' => $facilities[array_rand($facilities)],
                'admission_date' => $admissionDate,
                'sentence' => $sentenceYears . ' years',
                'sentence_end_date' => $sentenceEndDate,
                'offense' => $offenses[array_rand($offenses)],
                'readiness_score' => round($readinessScore),
                'is_parole_eligible' => $isParoleEligible,
                'parole_date' => $isParoleEligible ? $paroleEligibleDate : null,
                'emergency_contact_name' => 'Mrs. ' . $firstName . ' ' . $lastName,
                'emergency_contact_relationship' => $relationships[array_rand($relationships)],
                'emergency_contact_phone' => '+234 ' . rand(700, 909) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Inmate::insert($inmates);
    }
}
