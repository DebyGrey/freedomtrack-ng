<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate all tables with cascade to handle FKs in Postgres
        DB::statement('TRUNCATE activities, behavior_records, inmate_program, programs, inmates, users CASCADE;');

        $this->call([
            UserSeeder::class,
            InmateSeeder::class,
            ProgramSeeder::class,
            InmateProgramSeeder::class,
            BehaviorRecordSeeder::class,
            ActivitySeeder::class,
        ]);

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@freedomtrack.ng / password');
        $this->command->info('Officer: officer@freedomtrack.ng / password');
        $this->command->info('Judge: judge@freedomtrack.ng / password');
        $this->command->info('NGO: ngo@freedomtrack.ng / password');
        $this->command->info('Researcher: researcher@freedomtrack.ng / password');
    }
}
