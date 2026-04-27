<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KorlapController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Stats
        $totalSubordinates = User::where('role', 'worker')->count();
        $recentReports = DB::table('daily_reports')->where('user_id', $user->id)->latest()->limit(5)->get();
        $totalEarnings = DB::table('salaries')->where('user_id', $user->id)->sum('amount');

        // Mini Leaderboard (Same Area)
        $leaderboard = User::where('role', 'korlap')
            ->where('area', $user->area)
            ->orderBy('kpi_points', 'desc')
            ->limit(5)
            ->get();

        return view('korlap.dashboard', compact('user', 'totalSubordinates', 'recentReports', 'totalEarnings', 'leaderboard'));
    }

    public function attendance()
    {
        $subordinates = User::where('role', 'worker')->get();
        return view('korlap.attendance', compact('subordinates'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:users,id',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('attendances', 'public');
        }

        DB::table('attendances')->insert([
            'user_id' => $request->worker_id,
            'korlap_id' => auth()->id(),
            'status' => $request->status,
            'photo' => $photoPath,
            'location_lat' => $request->lat,
            'location_long' => $request->long,
            'notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Absensi berhasil dicatat.');
    }

    public function reports()
    {
        return view('korlap.reports');
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'progress' => 'required',
            'photo' => 'required|image|max:2048',
        ]);

        $photoPath = $request->file('photo')->store('reports', 'public');

        DB::table('daily_reports')->insert([
            'user_id' => auth()->id(),
            'progress' => $request->progress,
            'obstacles' => $request->obstacles,
            'photo' => $photoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Laporan harian berhasil dikirim.');
    }

    public function installationReport()
    {
        return view('korlap.installation-report');
    }

    public function storeInstallationReport(Request $request)
    {
        $request->validate([
            'unit_number' => 'required',
            'signal_strength' => 'required',
            'photo' => 'required|image|max:2048',
        ]);

        $photoPath = $request->file('photo')->store('installations', 'public');

        DB::table('installation_reports')->insert([
            'user_id' => auth()->id(),
            'unit_number' => $request->unit_number,
            'signal_strength' => $request->signal_strength,
            'photo' => $photoPath,
            'notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Laporan instalasi berhasil dikirim.');
    }

    public function directors()
    {
        $directors = DB::table('directors')->get();
        return view('korlap.directors', compact('directors'));
    }

    public function salaries()
    {
        $salaries = DB::table('salaries')
            ->where('user_id', auth()->id())
            ->orderBy('payment_date', 'desc')
            ->get();
        return view('korlap.salaries', compact('salaries'));
    }
}
