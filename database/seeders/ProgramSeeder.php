<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Program;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            // Vocational Programs
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Carpentry Skills Training',
                'category' => 'vocational',
                'duration' => '6 months',
                'capacity' => 30,
                'instructor' => 'Mr. Tunde Adeyemi',
                'start_date' => Carbon::now()->subMonths(8),
                'end_date' => Carbon::now()->subMonths(2),
                'status' => 'completed',
                'completion_rate' => 85,
                'description' => 'Comprehensive carpentry training covering basic to advanced woodworking skills, furniture making, and construction techniques.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Tailoring and Fashion Design',
                'category' => 'vocational',
                'duration' => '5 months',
                'capacity' => 25,
                'instructor' => 'Mrs. Folake Adebisi',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(2),
                'status' => 'active',
                'completion_rate' => 78,
                'description' => 'Learn tailoring skills, pattern making, and basic fashion design principles for entrepreneurship.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Auto Mechanics Training',
                'category' => 'vocational',
                'duration' => '8 months',
                'capacity' => 20,
                'instructor' => 'Mr. Emeka Okafor',
                'start_date' => Carbon::now()->subMonths(5),
                'end_date' => Carbon::now()->addMonths(3),
                'status' => 'active',
                'completion_rate' => 82,
                'description' => 'Hands-on training in vehicle maintenance, repair, and basic automotive engineering.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Welding and Fabrication',
                'category' => 'vocational',
                'duration' => '4 months',
                'capacity' => 15,
                'instructor' => 'Mr. Aliyu Garba',
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(5),
                'status' => 'upcoming',
                'completion_rate' => 0,
                'description' => 'Professional welding techniques and metal fabrication skills for industrial applications.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Electrical Installation',
                'category' => 'vocational',
                'duration' => '6 months',
                'capacity' => 18,
                'instructor' => 'Mr. Chidi Nwosu',
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(4),
                'status' => 'active',
                'completion_rate' => 75,
                'description' => 'Basic to intermediate electrical installation, wiring, and maintenance skills.',
            ],

            // Educational Programs
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Basic Computer Literacy',
                'category' => 'education',
                'duration' => '4 months',
                'capacity' => 35,
                'instructor' => 'Mr. James Okoro',
                'start_date' => Carbon::now()->subMonths(4),
                'end_date' => Carbon::now(),
                'status' => 'active',
                'completion_rate' => 88,
                'description' => 'Introduction to computers, internet usage, Microsoft Office, and basic digital skills.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Financial Literacy Workshop',
                'category' => 'education',
                'duration' => '2 months',
                'capacity' => 40,
                'instructor' => 'Mrs. Kemi Adebayo',
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(1),
                'status' => 'active',
                'completion_rate' => 92,
                'description' => 'Personal finance management, budgeting, banking, and entrepreneurship basics.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Adult Literacy Program',
                'category' => 'education',
                'duration' => '6 months',
                'capacity' => 50,
                'instructor' => 'Mrs. Aisha Musa',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(3),
                'status' => 'active',
                'completion_rate' => 70,
                'description' => 'Basic reading, writing, and numeracy skills for adult learners.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'English Language Improvement',
                'category' => 'education',
                'duration' => '3 months',
                'capacity' => 30,
                'instructor' => 'Mr. Biodun Ogundimu',
                'start_date' => Carbon::now()->addWeeks(2),
                'end_date' => Carbon::now()->addMonths(3)->addWeeks(2),
                'status' => 'upcoming',
                'completion_rate' => 0,
                'description' => 'Improve English communication skills for better reintegration opportunities.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Mathematics and Problem Solving',
                'category' => 'education',
                'duration' => '4 months',
                'capacity' => 25,
                'instructor' => 'Mrs. Ngozi Eze',
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(2),
                'status' => 'active',
                'completion_rate' => 76,
                'description' => 'Basic mathematics, logical thinking, and problem-solving skills.',
            ],

            // Therapy Programs
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Anger Management Therapy',
                'category' => 'therapy',
                'duration' => '3 months',
                'capacity' => 20,
                'instructor' => 'Dr. Sarah Ogundimu',
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(1),
                'status' => 'active',
                'completion_rate' => 95,
                'description' => 'Group therapy sessions focused on emotional regulation and conflict resolution techniques.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Substance Abuse Counseling',
                'category' => 'therapy',
                'duration' => '6 months',
                'capacity' => 15,
                'instructor' => 'Dr. Michael Okafor',
                'start_date' => Carbon::now()->subMonths(4),
                'end_date' => Carbon::now()->addMonths(2),
                'status' => 'active',
                'completion_rate' => 89,
                'description' => 'Individual and group counseling for substance abuse recovery and relapse prevention.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Mental Health Support Group',
                'category' => 'therapy',
                'duration' => '4 months',
                'capacity' => 25,
                'instructor' => 'Dr. Fatima Hassan',
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(3),
                'status' => 'active',
                'completion_rate' => 83,
                'description' => 'Peer support groups for mental health awareness and coping strategies.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Trauma Recovery Program',
                'category' => 'therapy',
                'duration' => '5 months',
                'capacity' => 12,
                'instructor' => 'Dr. Grace Nnamdi',
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(6),
                'status' => 'upcoming',
                'completion_rate' => 0,
                'description' => 'Specialized therapy for trauma recovery and post-traumatic stress management.',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Family Relationship Counseling',
                'category' => 'therapy',
                'duration' => '3 months',
                'capacity' => 18,
                'instructor' => 'Mrs. Comfort Yakubu',
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(2),
                'status' => 'active',
                'completion_rate' => 91,
                'description' => 'Counseling to rebuild and strengthen family relationships for successful reintegration.',
            ],
        ];

        foreach ($programs as $programData) {
            Program::create($programData);
        }
    }
}