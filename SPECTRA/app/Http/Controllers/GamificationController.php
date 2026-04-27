<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamificationController extends Controller
{
    public function leaderboard()
    {
        $user = auth()->user();
        
        // Battle of the Areas
        $areaLeaderboard = DB::table('projects')
            ->select('area', 
                DB::raw('SUM(contract_value) as total_revenue'),
                DB::raw('COUNT(*) as total_projects'),
                DB::raw('AVG(4.5) as satisfaction') // Mocked satisfaction
            )
            ->groupBy('area')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Top Performers per Role
        $topKorlaps = User::where('role', 'korlap')->orderBy('kpi_points', 'desc')->limit(10)->get();
        $topManagers = User::where('role', 'manager_area')->orderBy('kpi_points', 'desc')->limit(10)->get();

        return view('gamification.leaderboard', compact('areaLeaderboard', 'topKorlaps', 'topManagers'));
    }

    public function myStats()
    {
        $user = auth()->user();
        $kpiLogs = DB::table('kpi_logs')->where('user_id', $user->id)->latest()->limit(10)->get();
        $badges = DB::table('user_badges')
            ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
            ->where('user_id', $user->id)
            ->get();

        return view('gamification.my-stats', compact('user', 'kpiLogs', 'badges'));
    }

    public function wallOfFame()
    {
        $winners = User::where('kpi_points', '>', 500)
            ->orderBy('kpi_points', 'desc')
            ->limit(12)
            ->get();

        return view('gamification.wall-of-fame', compact('winners'));
    }

    // Admin Method (Dir SDM)
    public function adminSettings()
    {
        $badges = DB::table('badges')->get();
        return view('direksi.gamification-admin', compact('badges'));
    }

    public function addPoints(User $user, $points, $reason, $category)
    {
        $user->increment('kpi_points', $points);
        
        DB::table('kpi_logs')->insert([
            'user_id' => $user->id,
            'points_change' => $points,
            'reason' => $reason,
            'category' => $category,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Check for badge awards logic could go here
    }
}
