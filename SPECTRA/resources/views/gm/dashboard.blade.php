@extends('layouts.gm', ['title' => 'Papan Skor Lini Bisnis ' . auth()->user()->business_line])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <p class="text-gray-400 text-xs font-bold uppercase mb-2 tracking-widest">Total Pendapatan</p>
        <h3 class="text-3xl font-extrabold text-emerald-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
        <i class="fas fa-chart-line absolute -bottom-2 -right-2 text-6xl text-emerald-50 group-hover:scale-110 transition-transform"></i>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <p class="text-gray-400 text-xs font-bold uppercase mb-2 tracking-widest">Proyek Aktif</p>
        <h3 class="text-3xl font-extrabold text-blue-600">{{ $stats['active_projects'] }}</h3>
        <i class="fas fa-spinner absolute -bottom-2 -right-2 text-6xl text-blue-50 group-hover:rotate-12 transition-transform"></i>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <p class="text-gray-400 text-xs font-bold uppercase mb-2 tracking-widest">Proyek Selesai</p>
        <h3 class="text-3xl font-extrabold text-purple-600">{{ $stats['completed_projects'] }}</h3>
        <i class="fas fa-check-double absolute -bottom-2 -right-2 text-6xl text-purple-50 group-hover:scale-110 transition-transform"></i>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group">
        <p class="text-gray-400 text-xs font-bold uppercase mb-2 tracking-widest">Wilayah Operasional</p>
        <h3 class="text-3xl font-extrabold text-orange-600">{{ $stats['total_areas'] }} Area</h3>
        <i class="fas fa-map-marked-alt absolute -bottom-2 -right-2 text-6xl text-orange-50 group-hover:scale-110 transition-transform"></i>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Area Performance Rankings -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-extrabold text-gray-800 text-lg uppercase tracking-wider">Performa Area</h3>
            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-extrabold uppercase">Live Score</span>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                @foreach($area_performance as $performance)
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <h4 class="font-extrabold text-gray-800">{{ $performance->area }}</h4>
                                <p class="text-xs text-gray-400">{{ $performance->total_projects }} Proyek Terdaftar</p>
                            </div>
                            <span class="font-extrabold text-emerald-600">Rp {{ number_format($performance->total_revenue, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                            @php
                                $percentage = ($stats['total_revenue'] > 0) ? ($performance->total_revenue / $stats['total_revenue']) * 100 : 0;
                            @endphp
                            <div class="bg-emerald-500 h-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- GM Action Board -->
    <div class="space-y-6">
        <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
            <div class="relative z-10">
                <h3 class="text-xl font-extrabold mb-4 uppercase tracking-widest">Visi Lini Bisnis</h3>
                <p class="text-emerald-100 text-sm leading-relaxed mb-6 opacity-80">
                    Sebagai General Manager, tugas utama Anda adalah memastikan profitabilitas dan kualitas layanan di seluruh area. 
                    Monitor kinerja Manager Area dan pastikan setiap kontrak terdokumentasi dengan baik.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('gm.monitoring') }}" class="px-6 py-3 bg-emerald-600 rounded-2xl font-bold text-sm hover:bg-emerald-700 transition-all">Monitor Nasional</a>
                    <a href="{{ route('gm.contracts') }}" class="px-6 py-3 bg-white/10 border border-white/20 rounded-2xl font-bold text-sm hover:bg-white/20 transition-all text-white">Kelola Kontrak</a>
                </div>
            </div>
            <i class="fas fa-chess-king absolute -bottom-10 -right-10 text-[180px] text-white/5"></i>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <h3 class="font-extrabold text-gray-800 text-lg uppercase tracking-wider mb-6">Pemberitahuan Lini Bisnis</h3>
            <div class="space-y-4">
                <div class="flex gap-4 p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <i class="fas fa-info-circle text-emerald-600 mt-1"></i>
                    <div>
                        <p class="text-sm font-bold text-emerald-900">Target Kuartal II</p>
                        <p class="text-xs text-emerald-700">Tingkatkan efisiensi biaya operasional sebesar 10% di area Semarang.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Battle of the Areas Mini -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-extrabold text-gray-800 text-lg uppercase tracking-wider italic">Battle of The Areas</h3>
                <a href="{{ route('gamification.leaderboard') }}" class="text-[10px] font-black text-emerald-600 uppercase">Detail</a>
            </div>
            <div class="space-y-4">
                @foreach($areaLeaderboard as $index => $area)
                    <div class="flex items-center justify-between p-3 {{ $index === 0 ? 'bg-emerald-50 rounded-xl border border-emerald-100' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black {{ $index === 0 ? 'text-emerald-600' : 'text-slate-300' }}">#{{ $index + 1 }}</span>
                            <span class="text-xs font-bold text-slate-800">{{ $area->area }}</span>
                        </div>
                        <span class="text-xs font-black text-emerald-600">Rp {{ number_format($area->total_revenue / 1000000, 1) }}M</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
