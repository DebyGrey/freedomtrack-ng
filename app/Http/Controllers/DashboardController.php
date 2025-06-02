<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inmate;
use App\Models\Program;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get selected role (default to correctional)
        $selectedRole = $request->query('role', 'correctional');

        // Dashboard statistics
        $stats = [
            'totalInmates' => Inmate::count(),
            'activePrograms' => Program::where('status', 'active')->count(),
            'paroleEligible' => Inmate::where('is_parole_eligible', true)->count(),
            'reintegrationReady' => Inmate::where('readiness_score', '>=', 85)->count(),
        ];

        // Recent activities
        $recentActivities = Activity::with('inmate')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Upcoming paroles
        $upcomingParoles = Inmate::where('is_parole_eligible', true)
            ->orderBy('parole_date')
            ->take(3)
            ->get();

        return view('dashboard', compact('stats', 'recentActivities', 'upcomingParoles', 'selectedRole'));
    }

    public function reports()
    {
        // Get rehabilitation program statistics
        $programStats = Program::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        // Get readiness score distribution
        $readinessDistribution = Inmate::select(
            DB::raw('CASE 
                    WHEN readiness_score BETWEEN 0 AND 25 THEN "0-25"
                    WHEN readiness_score BETWEEN 26 AND 50 THEN "26-50"
                    WHEN readiness_score BETWEEN 51 AND 75 THEN "51-75"
                    ELSE "76-100"
                END as range'),
            DB::raw('count(*) as count')
        )
            ->groupBy('range')
            ->get();

        return view('reports', compact('programStats', 'readinessDistribution'));
    }
}
