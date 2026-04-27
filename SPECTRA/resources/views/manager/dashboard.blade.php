@extends('layouts.manager', ['title' => 'Ringkasan Area'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-blue-400 transition-all">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Proyek Aktif</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['total_projects'] }} <span class="text-sm text-slate-400">Unit</span></h3>
            <p class="text-[10px] text-blue-500 font-bold mt-2">Area {{ auth()->user()->area }}</p>
        </div>
        <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
            <i class="fas fa-briefcase"></i>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-purple-400 transition-all">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Korlap</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['total_korlap'] }} <span class="text-sm text-slate-400">Org</span></h3>
            <p class="text-[10px] text-purple-500 font-bold mt-2">Pimpinan Lapangan</p>
        </div>
        <div class="w-16 h-16 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-all">
            <i class="fas fa-user-tie"></i>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-orange-400 transition-all">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Pekerja</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $stats['total_workers'] }} <span class="text-sm text-slate-400">Org</span></h3>
            <p class="text-[10px] text-orange-500 font-bold mt-2">Tukang & Teknisi</p>
        </div>
        <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-all">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-emerald-400 transition-all">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Omzet Area</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">Rp {{ number_format($stats['revenue_month'] / 1000000, 1) }}M</h3>
            <p class="text-[10px] text-emerald-500 font-bold mt-2">Bulan Ini</p>
        </div>
        <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all">
            <i class="fas fa-money-bill-trend-up"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Projects -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Proyek Terbaru di {{ auth()->user()->area }}</h3>
            <a href="{{ route('manager.projects.index') }}" class="text-sm text-blue-600 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Proyek</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Klien</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recent_projects as $project)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-gray-800">{{ $project->name }}</p>
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $project->service_type }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $project->client_name }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-right text-gray-900">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada proyek yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="bg-blue-600 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
            <h3 class="text-xl font-bold mb-2">Deal Baru Selesai?</h3>
            <p class="text-blue-100 text-sm mb-6">Segera daftarkan proyek baru untuk memulai koordinasi dengan Korlap.</p>
            <a href="{{ route('manager.projects.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-2xl font-bold text-sm inline-block shadow-lg">
                Input Proyek Baru
            </a>
            <i class="fas fa-handshake absolute -bottom-4 -right-4 text-8xl text-white/10"></i>
        </div>

        <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-lg">
            <h3 class="font-bold mb-4">Butuh Rekap Gaji?</h3>
            <p class="text-gray-400 text-sm mb-6">Hitung otomatis bagi hasil sesuai skema 5:3:1:1 untuk area Anda.</p>
            <a href="{{ route('manager.salary-recap') }}" class="flex items-center justify-between group">
                <span class="font-bold">Buka Rekap Gaji</span>
                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
    </div>

    <!-- Mini Leaderboard -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-amber-50/30">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-widest italic">Peringkat Manager - Lini {{ $user->business_line }}</h3>
            <a href="{{ route('gamification.leaderboard') }}" class="text-[10px] font-black text-amber-600 uppercase">Lihat Semua</a>
        </div>
        <div class="p-6 space-y-4">
            @foreach($leaderboard as $index => $rank)
                <div class="flex items-center justify-between p-3 {{ $rank->id === auth()->id() ? 'bg-amber-50 rounded-xl border border-amber-100' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-black text-slate-400">#{{ $index + 1 }}</span>
                        <img src="{{ $rank->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($rank->name) }}" class="w-8 h-8 rounded-lg">
                        <span class="text-xs font-bold text-slate-800">{{ $rank->name }} {{ $rank->id === auth()->id() ? '(Anda)' : '' }}</span>
                    </div>
                    <span class="text-xs font-black text-amber-600">{{ $rank->kpi_points }} Pts</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
