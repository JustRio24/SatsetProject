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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    <!-- Battle of the Areas -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter italic">Battle of The Areas</h2>
            <span class="px-4 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase tracking-widest animate-pulse">Live Ranking</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($areaLeaderboard->take(3) as $index => $area)
                <div class="relative bg-white rounded-[2.5rem] p-8 shadow-xl border-t-8 {{ $index === 0 ? 'border-amber-400' : ($index === 1 ? 'border-slate-300' : 'border-amber-700') }} overflow-hidden">
                    <div class="absolute -top-4 -right-4 text-8xl font-black text-slate-50 opacity-50">{{ $index + 1 }}</div>
                    <div class="relative z-10 text-center">
                        <i class="fas fa-crown text-4xl mb-4 {{ $index === 0 ? 'text-amber-400' : ($index === 1 ? 'text-slate-300' : 'text-amber-700') }}"></i>
                        <h3 class="text-2xl font-black text-slate-800 uppercase">{{ $area->area }}</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Area Championship</p>
                        
                        <div class="mt-8 space-y-2">
                            <p class="text-3xl font-black text-slate-900">Rp {{ number_format($area->total_revenue / 1000000, 1) }}M</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Total Revenue</p>
                        </div>

                        <div class="mt-6 flex justify-center gap-4">
                            <div class="text-center">
                                <p class="text-sm font-bold text-slate-800">{{ $area->total_projects }}</p>
                                <p class="text-[8px] text-slate-400 uppercase">Proyek</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-bold text-slate-800">{{ number_format($area->satisfaction, 1) }}</p>
                                <p class="text-[8px] text-slate-400 uppercase">Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Rank</th>
                        <th class="px-8 py-5">Area</th>
                        <th class="px-8 py-5">Revenue</th>
                        <th class="px-8 py-5">Growth</th>
                        <th class="px-8 py-5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($areaLeaderboard->skip(3) as $index => $area)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 font-black text-slate-400">#{{ $index + 4 }}</td>
                            <td class="px-8 py-5 font-bold text-slate-800">{{ $area->area }}</td>
                            <td class="px-8 py-5 text-sm font-black text-slate-900">Rp {{ number_format($area->total_revenue, 0, ',', '.') }}</td>
                            <td class="px-8 py-5 text-emerald-500 font-bold text-xs"><i class="fas fa-arrow-up"></i> +4.2%</td>
                            <td class="px-8 py-5 text-right">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase">Challenger</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Top Korlaps -->
        <div class="space-y-6">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest border-l-4 border-indigo-500 pl-4">Korlap Terbaik (Top 10)</h3>
            <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden">
                <div class="p-8 space-y-6">
                    @foreach($topKorlaps as $index => $korlap)
                        <div class="flex items-center justify-between p-4 {{ $index < 3 ? 'bg-indigo-50 rounded-2xl border border-indigo-100' : '' }}">
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-black {{ $index < 3 ? 'text-indigo-600' : 'text-slate-300' }}">#{{ $index + 1 }}</span>
                                <img src="{{ $korlap->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($korlap->name) }}" class="w-12 h-12 rounded-xl border-2 {{ $index < 3 ? 'border-indigo-400' : 'border-slate-100' }}">
                                <div>
                                    <h4 class="font-extrabold text-slate-800 leading-none">{{ $korlap->name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Area {{ $korlap->area }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-black text-slate-900">{{ $korlap->kpi_points }}</p>
                                <div class="flex gap-0.5 text-[8px] text-amber-400">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Managers -->
        <div class="space-y-6">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest border-l-4 border-amber-500 pl-4">Manager Terbaik (Top 10)</h3>
            <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden">
                <div class="p-8 space-y-6">
                    @foreach($topManagers as $index => $manager)
                        <div class="flex items-center justify-between p-4 {{ $index < 3 ? 'bg-amber-50 rounded-2xl border border-amber-100' : '' }}">
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-black {{ $index < 3 ? 'text-amber-600' : 'text-slate-300' }}">#{{ $index + 1 }}</span>
                                <img src="{{ $manager->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($manager->name) }}" class="w-12 h-12 rounded-xl border-2 {{ $index < 3 ? 'border-amber-400' : 'border-slate-100' }}">
                                <div>
                                    <h4 class="font-extrabold text-slate-800 leading-none">{{ $manager->name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Area {{ $manager->area }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-black text-slate-900">{{ $manager->kpi_points }}</p>
                                <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest">Profit PTG</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
