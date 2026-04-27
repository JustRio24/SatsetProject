@extends('layouts.korlap', ['title' => 'Ringkasan Aktivitas'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-red-400 transition-all">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Anak Buah</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $totalSubordinates }} <span class="text-sm text-slate-400">Org</span></h3>
            <p class="text-[10px] text-red-500 font-bold mt-2"><i class="fas fa-users mr-1"></i> Tim Aktif Lapangan</p>
        </div>
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-red-600 group-hover:text-white transition-all">
            <i class="fas fa-user-group"></i>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-emerald-400 transition-all">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Gaji Diterima</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">Rp {{ number_format($totalEarnings / 1000, 0) }}k</h3>
            <p class="text-[10px] text-emerald-500 font-bold mt-2"><i class="fas fa-wallet mr-1"></i> Bonus & Gaji</p>
        </div>
        <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all">
            <i class="fas fa-coins"></i>
        </div>
    </div>

    <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group">
        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-2">Status Operasional</p>
        <h4 class="text-2xl font-black uppercase text-amber-400">AKTIF / NORMAL</h4>
        <div class="mt-4">
            <span class="px-3 py-1 bg-white/10 rounded-lg text-[8px] font-black uppercase tracking-widest">System Online</span>
        </div>
        <i class="fas fa-shield-halved absolute -bottom-4 -right-4 text-7xl text-white/5 group-hover:scale-110 transition-transform"></i>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Reports -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Laporan Harian Terbaru</h3>
            <a href="{{ route('korlap.reports') }}" class="text-sm text-red-600 font-medium">Lihat Semua</a>
        </div>
        <div class="p-6">
            @forelse($recentReports as $report)
                <div class="flex gap-4 mb-6 last:mb-0">
                    <img src="{{ asset('storage/' . $report->photo) }}" class="w-20 h-20 rounded-xl object-cover shadow-sm" onerror="this.src='https://placehold.co/100x100?text=Foto+Proyek'">
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <h4 class="font-semibold text-gray-800">{{ \Illuminate\Support\Str::limit($report->progress, 50) }}</h4>
                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($report->obstacles ?? 'Tidak ada kendala', 60) }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada laporan hari ini.</p>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="bg-red-600 rounded-2xl p-6 text-white shadow-lg shadow-red-200 relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xl font-bold mb-2">Sudah Absen Anak Buah?</h3>
                <p class="text-white/80 mb-4 text-sm">Pastikan semua personil di lapangan tercatat kehadirannya hari ini.</p>
                <a href="{{ route('korlap.attendance') }}" class="inline-block bg-white text-red-600 px-6 py-2 rounded-xl font-bold text-sm hover:bg-gray-100 transition-colors shadow-md">
                    Buka Absensi Sekarang
                </a>
            </div>
            <i class="fas fa-clipboard-list absolute -bottom-4 -right-4 text-8xl text-white/10"></i>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4">Informasi Perusahaan</h3>
            <div class="space-y-4">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <i class="fas fa-info-circle text-blue-500"></i>
                    <div>
                        <p class="text-sm font-semibold">Update Kebijakan Gaji</p>
                        <p class="text-xs text-gray-500">Berlaku mulai 1 Mei 2026</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <i class="fas fa-bullhorn text-orange-500"></i>
                    <div>
                        <p class="text-sm font-semibold">Safety First!</p>
                        <p class="text-xs text-gray-500">Wajib gunakan APD di lokasi proyek.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini Leaderboard -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-indigo-50/30">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-widest italic">Peringkat Korlap - Area {{ $user->area }}</h3>
            <a href="{{ route('gamification.leaderboard') }}" class="text-[10px] font-black text-indigo-600 uppercase">Lihat Semua</a>
        </div>
        <div class="p-6 space-y-4">
            @foreach($leaderboard as $index => $rank)
                <div class="flex items-center justify-between p-3 {{ $rank->id === auth()->id() ? 'bg-indigo-50 rounded-xl border border-indigo-100' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-black text-slate-400">#{{ $index + 1 }}</span>
                        <img src="{{ $rank->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($rank->name) }}" class="w-8 h-8 rounded-lg">
                        <span class="text-xs font-bold text-slate-800">{{ $rank->name }} {{ $rank->id === auth()->id() ? '(Anda)' : '' }}</span>
                    </div>
                    <span class="text-xs font-black text-indigo-600">{{ $rank->kpi_points }} Pts</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
