<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Consolidated Stats
        $totalRevenue = DB::table('projects')->sum('contract_value');
        $totalSalaries = DB::table('salaries')->sum('amount');
        $totalOtherExpenses = DB::table('expenses')->sum('amount');
        $totalExpenses = $totalSalaries + $totalOtherExpenses; 
        $profit = $totalRevenue - $totalExpenses;

        $revenuePerLine = DB::table('projects')
            ->select('service_type', DB::raw('SUM(contract_value) as total'))
            ->groupBy('service_type')
            ->get();

        $activeProjects = DB::table('projects')->where('status', 'active')->count();

        // Mini Leaderboard (Battle of the Areas)
        $areaLeaderboard = DB::table('projects')
            ->select('area', DB::raw('SUM(contract_value) as total_revenue'))
            ->groupBy('area')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return view('direksi.dashboard', compact('user', 'totalRevenue', 'totalExpenses', 'profit', 'revenuePerLine', 'activeProjects', 'areaLeaderboard'));
    }

    public function financialReports(Request $request)
    {
        $query = DB::table('projects');
        
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        if ($request->filled('line')) {
            $query->where('service_type', $request->line);
        }

        $projects = $query->get();
        $totalRevenue = $projects->sum('contract_value');
        
        // Simplified P&L logic
        $salaries = DB::table('salaries')->sum('amount');
        $operational = $totalRevenue * 0.1;
        $tax = $totalRevenue * 0.11;
        
        $areas = DB::table('projects')->distinct()->pluck('area');
        $lines = ['Bangunan', 'Bengkel', 'Entertainment', 'Antrian'];

        $totalOtherExpenses = DB::table('expenses')->sum('amount');
        $netProfit = $totalRevenue - ($salaries + $operational + $tax + $totalOtherExpenses);

        return view('direksi.financial', compact('projects', 'totalRevenue', 'salaries', 'operational', 'tax', 'areas', 'lines', 'totalOtherExpenses', 'netProfit'));
    }

    public function balanceSheet()
    {
        if (auth()->user()->position !== 'Direktur Utama' && auth()->user()->position !== 'Dirut') {
            abort(403, 'Hanya untuk Direktur Utama.');
        }

        // Mocking Balance Sheet data based on available transactions
        $totalRevenue = DB::table('projects')->sum('contract_value');
        $realizedRevenue = $totalRevenue * 0.7; // 70% paid by clients
        $receivables = $totalRevenue - $realizedRevenue; // 30% yet to be paid
        
        $totalSalaries = DB::table('salaries')->sum('amount');
        $realizedSalaries = DB::table('salaries')->whereNotNull('realized_at')->sum('amount');
        $payables = $totalSalaries - $realizedSalaries; // Salary debt

        $cash = $realizedRevenue - $realizedSalaries - DB::table('expenses')->sum('amount');

        return view('direksi.balance-sheet', compact('cash', 'receivables', 'payables'));
    }

    public function employeeLegal()
    {
        if (auth()->user()->position !== 'Dir SDM & Legal' && auth()->user()->position !== 'Dirut') {
            abort(403, 'Hanya untuk Direksi SDM & Legal.');
        }

        $employees = User::all();
        $documents = DB::table('legal_documents')->get();

        return view('direksi.sdm-legal', compact('employees', 'documents'));
    }

    public function uploadLegal(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'file' => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = $request->file('file')->store('legal', 'public');

        DB::table('legal_documents')->insert([
            'title' => $request->title,
            'category' => $request->category,
            'file_path' => $filePath,
            'expiry_date' => $request->expiry_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Dokumen legalitas berhasil diunggah.');
    }
    public function exportPdf(Request $request)
    {
        $projects = DB::table('projects')->get();
        $totalRevenue = $projects->sum('contract_value');
        $salaries = DB::table('salaries')->sum('amount');
        $operational = $totalRevenue * 0.1;
        $tax = $totalRevenue * 0.11;
        $totalOtherExpenses = DB::table('expenses')->sum('amount');
        $netProfit = $totalRevenue - ($salaries + $operational + $tax + $totalOtherExpenses);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('direksi.pdf.financial', compact(
            'projects', 'totalRevenue', 'salaries', 'operational', 'tax', 'totalOtherExpenses', 'netProfit'
        ));

        return $pdf->download('Laporan_Keuangan_Konsolidasi_' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        // Simple Excel export using a direct download or a class
        // For simplicity in this demo, we'll focus on the PDF which is more 'premium' for directors
        return back()->with('info', 'Fitur Ekspor Excel sedang dalam pemeliharaan.');
    }
}
