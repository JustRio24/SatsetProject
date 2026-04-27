@extends('layouts.korlap', ['title' => 'Ringkasan Aktivitas'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-red-400 transition-all animate-fade-in-up">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Anak Buah</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $totalSubordinates }} <span class="text-sm text-slate-400">Org</span></h3>
            <p class="text-[10px] text-red-500 font-bold mt-2"><i class="fas fa-users mr-1"></i> Tim Aktif Lapangan</p>
        </div>
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-red-600 group-hover:text-white transition-all">
            <i class="fas fa-user-group"></i>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 flex items-center justify-between group hover:border-emerald-400 transition-all animate-fade-in-up delay-100">
        <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Gaji Diterima</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">Rp {{ number_format($totalEarnings / 1000, 0) }}k</h3>
            <p class="text-[10px] text-emerald-500 font-bold mt-2"><i class="fas fa-wallet mr-1"></i> Bonus & Gaji</p>
        </div>
        <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all">
            <i class="fas fa-coins"></i>
        </div>
    </div>

    <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group animate-fade-in-up delay-200">
        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-2">Absensi Hari Ini</p>
        <h4 class="text-4xl font-black text-amber-400">{{ $todayAttendance }}
            <span class="text-lg text-slate-400 font-bold">/ {{ $totalSubordinates }} Org</span>
        </h4>
        <div class="mt-4">
            @if($todayAttendance >= $totalSubordinates && $totalSubordinates > 0)
                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-[8px] font-black uppercase tracking-widest"><i class="fas fa-check mr-1"></i>Semua Hadir</span>
            @elseif($todayAttendance > 0)
                <span class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-lg text-[8px] font-black uppercase tracking-widest"><i class="fas fa-clock mr-1"></i>Sebagian Terabsen</span>
            @else
                <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg text-[8px] font-black uppercase tracking-widest"><i class="fas fa-exclamation mr-1"></i>Belum Ada Absensi</span>
            @endif
        </div>
        <i class="fas fa-user-check absolute -bottom-4 -right-4 text-7xl text-white/5 group-hover:scale-110 transition-transform"></i>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Recent Reports -->
    <div class="xl:col-span-2 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="font-black text-slate-800 uppercase tracking-tighter italic">Laporan Harian Terbaru</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Update terakhir dari lapangan</p>
            </div>
            <a href="{{ route('korlap.reports') }}" class="text-[10px] font-black text-red-600 uppercase bg-red-50 px-4 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all">Lihat Semua</a>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                @forelse($recentReports as $report)
                    <div class="flex flex-col sm:flex-row gap-6 p-4 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                        <div class="relative shrink-0">
                            <img src="{{ asset('storage/' . $report->photo) }}" class="w-full sm:w-24 h-48 sm:h-24 rounded-2xl object-cover shadow-lg" onerror="this.src='https://placehold.co/400x300?text=Foto+Proyek'">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <h4 class="font-black text-slate-800 leading-tight group-hover:text-red-600 transition-colors">{{ \Illuminate\Support\Str::limit($report->progress, 80) }}</h4>
                                <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-500 font-medium line-clamp-2">{{ $report->obstacles ?? 'Progres berjalan lancar tanpa kendala teknis.' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 text-center py-8 font-bold uppercase text-[10px]">Belum ada laporan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar Right -->
    <div class="space-y-8">
        <!-- Quick Actions -->
        <div class="bg-red-600 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group animate-fade-in-up delay-100">
            <div class="relative z-10">
                <h3 class="text-xl font-black mb-2 uppercase tracking-tighter italic">Absensi Tim</h3>
                <p class="text-white/70 mb-6 text-sm">Sudahkah Anda mencatat kehadiran anak buah hari ini?</p>
                <a href="{{ route('korlap.attendance') }}" class="inline-flex items-center gap-2 bg-white text-red-600 px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-100 transition-all shadow-xl">
                    Buka Absensi <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <i class="fas fa-clipboard-check absolute -bottom-6 -right-6 text-9xl text-white/10"></i>
        </div>

        <!-- Leaderboard -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up delay-200">
            <div class="p-8 border-b border-slate-50 bg-indigo-50/30">
                <h3 class="font-black text-slate-800 text-[10px] uppercase tracking-[0.2em] italic">Top Performance - Area {{ $user->area }}</h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach($leaderboard as $index => $rank)
                    <div class="flex items-center gap-4 p-3 rounded-2xl {{ $rank->id === auth()->id() ? 'bg-indigo-50 border border-indigo-100' : '' }}">
                        <span class="text-xs font-black text-slate-400 w-4">#{{ $index + 1 }}</span>
                        <img src="{{ $rank->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($rank->name) }}" class="w-10 h-10 rounded-xl object-cover shadow-sm">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-slate-800 truncate">{{ $rank->name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $rank->kpi_points }} Pts</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
