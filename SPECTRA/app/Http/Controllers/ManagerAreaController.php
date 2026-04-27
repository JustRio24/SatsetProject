<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerAreaController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $area = $user->area;

        $stats = [
            'total_projects' => DB::table('projects')->where('area', $area)->count(),
            'total_korlap' => User::where('role', 'korlap')->where('area', $area)->count(),
            'total_workers' => User::where('role', 'worker')->where('area', $area)->count(),
            'revenue_month' => DB::table('projects')->where('area', $area)->whereMonth('created_at', now()->month)->sum('contract_value'),
        ];

        $recent_projects = DB::table('projects')->where('area', $area)->latest()->limit(5)->get();

        // Mini Leaderboard (Same Business Line)
        $leaderboard = User::where('role', 'manager_area')
            ->where('business_line', $user->business_line)
            ->orderBy('kpi_points', 'desc')
            ->limit(5)
            ->get();

        return view('manager.dashboard', compact('user', 'stats', 'recent_projects', 'leaderboard'));
    }

    public function projects()
    {
        $projects = DB::table('projects')->where('area', auth()->user()->area)->get();
        return view('manager.projects.index', compact('projects'));
    }

    public function createProject()
    {
        return view('manager.projects.create');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'client_name' => 'required',
            'service_type' => 'required|in:Bangunan,Bengkel,Entertainment,Antrian',
            'contract_value' => 'required|numeric',
            'duration' => 'required',
        ]);

        DB::table('projects')->insert([
            'name' => $request->name,
            'client_name' => $request->client_name,
            'service_type' => $request->service_type,
            'contract_value' => $request->contract_value,
            'duration' => $request->duration,
            'details' => $request->details,
            'area' => auth()->user()->area,
            'manager_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('manager.projects.index')->with('success', 'Proyek baru berhasil didaftarkan.');
    }

    public function team()
    {
        $area = auth()->user()->area;
        $korlaps = User::where('role', 'korlap')->where('area', $area)->get();
        $workers = User::where('role', 'worker')->where('area', $area)->get();

        return view('manager.team', compact('korlaps', 'workers'));
    }

    public function monitoring()
    {
        $area = auth()->user()->area;
        $reports = DB::table('daily_reports')
            ->join('users', 'daily_reports.user_id', '=', 'users.id')
            ->leftJoin('projects', 'daily_reports.project_id', '=', 'projects.id')
            ->where('users.area', $area)
            ->select('daily_reports.*', 'users.name as korlap_name', 'projects.name as project_name')
            ->latest()
            ->get();

        return view('manager.monitoring', compact('reports'));
    }

    public function salaryRecap()
    {
        $area = auth()->user()->area;
        // Simplified recap logic based on the user's request (5:3:1:1 scheme)
        // 5 (Worker), 3 (Company), 1 (Korlap), 1 (Manager Area)
        
        $projects = DB::table('projects')->where('area', $area)->get();
        
        $recaps = $projects->map(function($project) {
            $val = $project->contract_value;
            return [
                'project_id' => $project->id,
                'project_name' => $project->name,
                'total' => $val,
                'worker_share' => $val * 0.5,
                'company_share' => $val * 0.3,
                'korlap_share' => $val * 0.1,
                'manager_share' => $val * 0.1,
                'is_approved' => DB::table('salaries')->where('project_id', $project->id)->exists(),
            ];
        });

        return view('manager.salary-recap', compact('recaps'));
    }

    public function approveSalary($projectId)
    {
        $area = auth()->user()->area;
        $project = DB::table('projects')->where('id', $projectId)->where('area', $area)->first();

        if (!$project) {
            return back()->with('error', 'Proyek tidak ditemukan.');
        }

        if (DB::table('salaries')->where('project_id', $project->id)->exists()) {
            return back()->with('error', 'Rekap proyek ini sudah disetujui sebelumnya.');
        }

        $val = $project->contract_value;
        $workerShareTotal = $val * 0.5;
        $korlapShareTotal = $val * 0.1;
        $managerShareTotal = $val * 0.1;

        $workers = User::where('role', 'worker')->where('area', $area)->get();
        $korlaps = User::where('role', 'korlap')->where('area', $area)->get();

        $inserts = [];

        // Workers
        if ($workers->count() > 0) {
            $perWorker = $workerShareTotal / $workers->count();
            foreach ($workers as $worker) {
                $inserts[] = [
                    'user_id' => $worker->id,
                    'amount' => $perWorker,
                    'type' => 'gaji',
                    'status' => 'pending',
                    'payment_date' => now(),
                    'project_id' => $project->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Korlaps
        if ($korlaps->count() > 0) {
            $perKorlap = $korlapShareTotal / $korlaps->count();
            foreach ($korlaps as $korlap) {
                $inserts[] = [
                    'user_id' => $korlap->id,
                    'amount' => $perKorlap,
                    'type' => 'bagi_hasil',
                    'status' => 'pending',
                    'payment_date' => now(),
                    'project_id' => $project->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Manager
        $inserts[] = [
            'user_id' => auth()->id(),
            'amount' => $managerShareTotal,
            'type' => 'bagi_hasil',
            'status' => 'pending',
            'payment_date' => now(),
            'project_id' => $project->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('salaries')->insert($inserts);

        return back()->with('success', 'Rekap gaji proyek ' . $project->name . ' berhasil disetujui dan diteruskan ke Keuangan.');
    }

    public function approveAllSalaries()
    {
        $area = auth()->user()->area;
        $projects = DB::table('projects')->where('area', $area)->get();
        $count = 0;

        foreach ($projects as $project) {
            if (!DB::table('salaries')->where('project_id', $project->id)->exists()) {
                $this->approveSalary($project->id);
                $count++;
            }
        }

        return back()->with('success', $count . ' rekap gaji proyek berhasil disetujui.');
    }

    public function monthlyReport()
    {
        $area = auth()->user()->area;
        $month = now()->format('F Y');
        
        $revenue = DB::table('projects')
            ->where('area', $area)
            ->whereMonth('created_at', now()->month)
            ->sum('contract_value');

        // Assuming some expenses for demonstration
        $expenses = $revenue * 0.6; // Simplified: 60% for workers/others
        
        return view('manager.monthly-report', compact('revenue', 'expenses', 'month'));
    }
    public function exportPayouts()
    {
        $user = auth()->user();
        $payouts = DB::table('salaries')
            ->join('users', 'salaries.user_id', '=', 'users.id')
            ->where('users.area', $user->area)
            ->select('salaries.*', 'users.name as recipient_name', 'users.role as recipient_role')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('manager.pdf.payouts', compact('payouts', 'user'));
        return $pdf->download('Rekap_Gaji_Area_' . $user->area . '_' . now()->format('Y-m-d') . '.pdf');
    }
}
