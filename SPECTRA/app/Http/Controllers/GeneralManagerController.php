<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralManagerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $line = $user->business_line;

        $stats = [
            'total_revenue' => DB::table('projects')->where('service_type', $line)->sum('contract_value'),
            'active_projects' => DB::table('projects')->where('service_type', $line)->where('status', 'active')->count(),
            'completed_projects' => DB::table('projects')->where('service_type', $line)->where('status', 'completed')->count(),
            'total_areas' => DB::table('projects')->where('service_type', $line)->distinct('area')->count('area'),
        ];

        $area_performance = DB::table('projects')
            ->where('service_type', $line)
            ->select('area', DB::raw('SUM(contract_value) as total_revenue'), DB::raw('COUNT(*) as total_projects'))
            ->groupBy('area')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Mini Leaderboard (Battle of the Areas)
        $areaLeaderboard = DB::table('projects')
            ->select('area', DB::raw('SUM(contract_value) as total_revenue'))
            ->groupBy('area')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return view('gm.dashboard', compact('user', 'stats', 'area_performance', 'areaLeaderboard'));
    }

    public function monitoring()
    {
        $line = auth()->user()->business_line;
        
        $reports = DB::table('daily_reports')
            ->join('users', 'daily_reports.user_id', '=', 'users.id')
            ->join('projects', 'daily_reports.project_id', '=', 'projects.id')
            ->where('projects.service_type', $line)
            ->select('daily_reports.*', 'users.name as korlap_name', 'projects.name as project_name', 'projects.area')
            ->latest()
            ->get();

        return view('gm.monitoring', compact('reports'));
    }

    public function contracts()
    {
        $line = auth()->user()->business_line;
        $projects = DB::table('projects')->where('service_type', $line)->get();
        return view('gm.contracts', compact('projects'));
    }

    public function uploadContract(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'contract_file' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $request->file('contract_file')->store('contracts', 'public');

        DB::table('projects')->where('id', $request->project_id)->update([
            'contract_file' => $filePath,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'File kontrak berhasil diunggah.');
    }

    public function gamification()
    {
        $line = auth()->user()->business_line;

        $manager_rankings = User::where('role', 'manager_area')
            ->where('business_line', $line)
            ->orderBy('kpi_points', 'desc')
            ->get();

        $korlap_rankings = User::where('role', 'korlap')
            ->where('business_line', $line)
            ->orderBy('kpi_points', 'desc')
            ->get();

        return view('gm.gamification', compact('manager_rankings', 'korlap_rankings'));
    }
}
