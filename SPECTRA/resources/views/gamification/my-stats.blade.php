@php
    $layout = 'layouts.app';
    if(auth()->user()->isKorlap()) $layout = 'layouts.korlap';
    elseif(auth()->user()->isManagerArea()) $layout = 'layouts.manager';
    elseif(auth()->user()->isGM()) $layout = 'layouts.gm';
    elseif(auth()->user()->isDireksi()) $layout = 'layouts.direksi';
    elseif(auth()->user()->role === 'finance') $layout = 'layouts.finance';
@endphp

@extends($layout)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12 space-y-12">
    <!-- Profile Header -->
    <div class="bg-slate-900 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
            <div class="relative">
                <img src="{{ $user->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-40 h-40 rounded-[2.5rem] border-4 border-amber-400 shadow-2xl shadow-amber-400/20">
                <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-amber-400 rounded-2xl flex items-center justify-center text-slate-900 text-2xl font-black shadow-lg">
                    Lvl 8
                </div>
            </div>
            <div class="text-center md:text-left flex-1">
                <h2 class="text-4xl font-black tracking-tight mb-2 uppercase">{{ $user->name }}</h2>
                <p class="text-amber-400 font-bold uppercase tracking-[0.2em] text-sm">{{ $user->position ?? $user->role }}</p>
                
                <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Total KPI Points</p>
                        <p class="text-3xl font-black">{{ $user->kpi_points }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Rank Nasional</p>
                        <p class="text-3xl font-black">#14</p>
                    </div>
                    <div class="hidden md:block">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Achievement</p>
                        <p class="text-3xl font-black">{{ $badges->count() }} Badges</p>
                    </div>
                </div>
            </div>
        </div>
        <i class="fas fa-trophy absolute -bottom-10 -right-10 text-[200px] text-white/5"></i>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Badges Collection -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest italic">Koleksi Lencana Penghargaan</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @forelse($badges as $badge)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-center group hover:bg-amber-400 transition-all cursor-help relative">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center text-2xl" style="background: {{ $badge->color }}20; color: {{ $badge->color }}">
                            <i class="fas {{ $badge->icon }}"></i>
                        </div>
                        <p class="text-[10px] font-black uppercase text-slate-800 tracking-tighter">{{ $badge->name }}</p>
                        <div class="absolute inset-0 p-4 bg-slate-900 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-center">
                            <p class="text-[10px] text-white font-bold leading-tight">{{ $badge->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                        <p class="text-xs text-slate-400 font-bold uppercase">Selesaikan misi untuk mendapatkan badge pertama Anda!</p>
                    </div>
                @endforelse
            </div>

            <!-- Activity Log -->
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest italic mt-12">Log Aktivitas KPI</h3>
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-0">
                    @foreach($kpiLogs as $log)
                        <div class="flex items-center justify-between p-6 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $log->points_change > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    <i class="fas {{ $log->points_change > 0 ? 'fa-plus' : 'fa-minus' }}"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $log->reason }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $log->category }} • {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-lg font-black {{ $log->points_change > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $log->points_change > 0 ? '+' : '' }}{{ $log->points_change }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- KPI Breakdown -->
        <div class="space-y-6">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest italic">Analisis KPI Saya</h3>
            <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 space-y-8">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Kehadiran & Kedisplinan</span>
                        <span class="text-sm font-black text-slate-900">92%</span>
                    </div>
                    <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full" style="width: 92%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Kualitas & Laporan</span>
                        <span class="text-sm font-black text-slate-900">85%</span>
                    </div>
                    <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Akurasi Data</span>
                        <span class="text-sm font-black text-slate-900">100%</span>
                    </div>
                    <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-full" style="width: 100%"></div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-400 font-bold mb-4">Butuh 280 poin lagi untuk naik ke Level 9</p>
                    <button class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl">
                        Lihat Misi Harian
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
