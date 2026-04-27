@extends('layouts.direksi', ['title' => 'Dashboard Utama Perusahaan'])

@section('content')
<!-- Financial Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <div class="lg:col-span-2 bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-4">Konsolidasi Pendapatan Nasional</p>
            <div class="flex items-end gap-4 mb-8">
                <h3 class="text-5xl font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <span class="text-emerald-500 font-bold text-sm mb-2"><i class="fas fa-caret-up"></i> +14.2%</span>
            </div>
            
            <div class="h-64 mt-4">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-slate-900 p-8 rounded-[2rem] text-white shadow-2xl relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-2">Total Laba (EBITDA)</p>
            <h4 class="text-3xl font-black {{ $profit >= 0 ? 'text-amber-400' : 'text-red-400' }}">Rp {{ number_format($profit, 0, ',', '.') }}</h4>
            <div class="mt-6 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                <span class="text-slate-500">Margin Profit</span>
                <span class="text-amber-400">22.5%</span>
            </div>
            <div class="mt-2 w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amber-400 h-full" style="width: 22.5%"></div>
            </div>
            <i class="fas fa-vault absolute -bottom-4 -right-4 text-7xl text-white/5 group-hover:scale-110 transition-transform"></i>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50">
            <h4 class="font-bold text-slate-800 mb-6 uppercase text-xs tracking-widest">Revenue per Lini Bisnis</h4>
            <div class="space-y-6">
                @foreach($revenuePerLine as $line)
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-slate-500 uppercase">{{ $line->service_type }}</span>
                            <span class="text-slate-900">Rp {{ number_format($line->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                            @php $pct = ($totalRevenue > 0) ? ($line->total / $totalRevenue) * 100 : 0; @endphp
                            <div class="bg-slate-900 h-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 flex items-center gap-5">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">
            <i class="fas fa-diagram-project"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Proyek Aktif</p>
            <h5 class="text-lg font-black text-slate-900">{{ $activeProjects }} Nasional</h5>
        </div>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 flex items-center gap-5">
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl">
            <i class="fas fa-money-bill-transfer"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pengeluaran</p>
            <h5 class="text-lg font-black text-slate-900">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h5>
        </div>
    </div>
    <!-- ... more stats if needed -->
</div>

<!-- Battle of the Areas Mini -->
<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden mb-12">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-900 text-white">
        <h3 class="font-black uppercase tracking-widest text-sm italic">Battle of The Areas (Top 5 Nasional)</h3>
        <a href="{{ route('gamification.leaderboard') }}" class="text-[10px] font-black text-amber-400 uppercase">View All</a>
    </div>
    <div class="p-8 grid grid-cols-1 md:grid-cols-5 gap-6">
        @foreach($areaLeaderboard as $index => $area)
            <div class="text-center p-6 rounded-3xl {{ $index === 0 ? 'bg-amber-50 border border-amber-200' : 'bg-slate-50 border border-slate-100' }}">
                <p class="text-xs font-black {{ $index === 0 ? 'text-amber-600' : 'text-slate-400' }} mb-2">#{{ $index + 1 }}</p>
                <h4 class="text-sm font-black text-slate-800 uppercase">{{ $area->area }}</h4>
                <p class="text-[10px] font-bold text-slate-400 mt-1">Rp {{ number_format($area->total_revenue / 1000000, 1) }}M</p>
            </div>
        @endforeach
    </div>
</div>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Revenue Trend (Consolidated)',
                data: [120000000, 190000000, 150000000, 250000000, 220000000, 300000000],
                borderColor: '#0f172a',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(15, 23, 42, 0.05)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection
