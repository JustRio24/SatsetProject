<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function dashboard()
    {
        $pendingPayouts = DB::table('salaries')->whereNull('realized_at')->count();
        $totalExpensesThisMonth = DB::table('expenses')->whereMonth('date', now()->month)->sum('amount');
        $recentExpenses = DB::table('expenses')
            ->join('projects', 'expenses.project_id', '=', 'projects.id')
            ->select('expenses.*', 'projects.name as project_name')
            ->latest('date')
            ->limit(5)
            ->get();

        // Mini Leaderboard (Battle of the Areas)
        $areaLeaderboard = DB::table('projects')
            ->select('area', DB::raw('SUM(contract_value) as total_revenue'))
            ->groupBy('area')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return view('finance.dashboard', compact('pendingPayouts', 'totalExpensesThisMonth', 'recentExpenses', 'areaLeaderboard'));
    }

    public function payoutApproval()
    {
        $payouts = DB::table('salaries')
            ->join('users', 'salaries.user_id', '=', 'users.id')
            ->leftJoin('projects', 'salaries.project_id', '=', 'projects.id')
            ->select('salaries.*', 'users.name as user_name', 'users.role as user_role', 'projects.name as project_name')
            ->whereNull('realized_at')
            ->get();

        return view('finance.payouts', compact('payouts'));
    }

    public function realizePayout($id)
    {
        DB::table('salaries')->where('id', $id)->update([
            'realized_at' => now(),
            'status' => 'paid',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran telah direalisasikan.');
    }

    public function expenses()
    {
        $projects = DB::table('projects')->get();
        $expenses = DB::table('expenses')
            ->join('projects', 'expenses.project_id', '=', 'projects.id')
            ->select('expenses.*', 'projects.name as project_name')
            ->latest('date')
            ->get();

        return view('finance.expenses', compact('projects', 'expenses'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        DB::table('expenses')->insert([
            'project_id' => $request->project_id,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Biaya operasional berhasil dicatat.');
    }
}
