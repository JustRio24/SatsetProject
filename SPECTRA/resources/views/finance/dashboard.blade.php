@extends('layouts.finance', ['title' => 'Dashboard Keuangan'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Payout Menunggu</p>
            <h3 class="text-3xl font-black text-indigo-600">{{ $pendingPayouts }} Transaksi</h3>
        </div>
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all">
            <i class="fas fa-hourglass-half"></i>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Operasional Bulan Ini</p>
            <h3 class="text-3xl font-black text-rose-600">Rp {{ number_format($totalExpensesThisMonth, 0, ',', '.') }}</h3>
        </div>
        <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-rose-600 group-hover:text-white transition-all">
            <i class="fas fa-wallet"></i>
        </div>
    </div>

    <div class="bg-indigo-900 p-8 rounded-3xl text-white shadow-xl relative overflow-hidden">
        <h3 class="text-xl font-bold mb-2">Real-time Balance</h3>
        <p class="text-indigo-300 text-xs">Integrasi data hilir ke hulu aktif.</p>
        <i class="fas fa-chart-line absolute -bottom-4 -right-4 text-7xl text-white/10"></i>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Biaya Operasional Terbaru</h3>
        <a href="{{ route('finance.expenses') }}" class="text-sm font-bold text-indigo-600 uppercase tracking-widest">Lihat Semua</a>
    </div>
    <div class="p-0">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-8 py-4">Proyek</th>
                    <th class="px-8 py-4">Kategori</th>
                    <th class="px-8 py-4">Jumlah</th>
                    <th class="px-8 py-4">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($recentExpenses as $expense)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 text-sm font-bold text-slate-800">{{ $expense->project_name }}</td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase">{{ $expense->category }}</span>
                        </td>
                        <td class="px-8 py-5 text-sm font-black text-rose-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                        <td class="px-8 py-5 text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Battle of the Areas Mini -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mt-8">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-indigo-50/30">
        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-widest italic">Battle of The Areas</h3>
        <a href="{{ route('gamification.leaderboard') }}" class="text-[10px] font-black text-indigo-600 uppercase">Detail</a>
    </div>
    <div class="p-8 space-y-4">
        @foreach($areaLeaderboard as $index => $area)
            <div class="flex items-center justify-between p-3 {{ $index === 0 ? 'bg-indigo-50 rounded-xl border border-indigo-100' : '' }}">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black {{ $index === 0 ? 'text-indigo-600' : 'text-slate-300' }}">#{{ $index + 1 }}</span>
                    <span class="text-xs font-bold text-slate-800">{{ $area->area }}</span>
                </div>
                <span class="text-xs font-black text-indigo-600">Rp {{ number_format($area->total_revenue / 1000000, 1) }}M</span>
            </div>
        @endforeach
    </div>
</div>
@endsection
