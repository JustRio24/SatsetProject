@extends('layouts.gm', ['title' => 'KPI & Gamifikasi Lini Bisnis'])

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- Manager Area Rankings -->
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-medal"></i>
            </div>
            <h3 class="font-extrabold text-xl text-gray-800 uppercase tracking-widest">Peringkat Manager Area</h3>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8 space-y-6">
                @foreach($manager_rankings as $index => $manager)
                    <div class="flex items-center justify-between p-4 {{ $index === 0 ? 'bg-emerald-50 rounded-2xl border border-emerald-100' : '' }}">
                        <div class="flex items-center gap-4">
                            <span class="text-lg font-black {{ $index === 0 ? 'text-emerald-600' : 'text-gray-300' }}">#{{ $index + 1 }}</span>
                            <img src="{{ $manager->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($manager->name) }}" class="w-12 h-12 rounded-xl border-2 {{ $index === 0 ? 'border-emerald-500' : 'border-gray-100' }}">
                            <div>
                                <h4 class="font-extrabold text-gray-800 leading-none">{{ $manager->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Area {{ $manager->area }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-black text-gray-800">{{ $manager->kpi_points }}</p>
                            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">KPI PTS</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Korlap Rankings -->
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-trophy"></i>
            </div>
            <h3 class="font-extrabold text-xl text-gray-800 uppercase tracking-widest">Peringkat Korlap Terbaik</h3>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8 space-y-6">
                @foreach($korlap_rankings as $index => $korlap)
                    <div class="flex items-center justify-between p-4 {{ $index === 0 ? 'bg-blue-50 rounded-2xl border border-blue-100' : '' }}">
                        <div class="flex items-center gap-4">
                            <span class="text-lg font-black {{ $index === 0 ? 'text-blue-600' : 'text-gray-300' }}">#{{ $index + 1 }}</span>
                            <img src="{{ $korlap->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($korlap->name) }}" class="w-12 h-12 rounded-xl border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-100' }}">
                            <div>
                                <h4 class="font-extrabold text-gray-800 leading-none">{{ $korlap->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Area {{ $korlap->area }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-black text-gray-800">{{ $korlap->kpi_points }}</p>
                            <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">XP POINTS</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="mt-12 p-8 bg-slate-900 rounded-3xl text-white flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
    <div class="relative z-10">
        <h3 class="font-extrabold text-lg uppercase tracking-widest mb-2">Sistem Reward Perusahaan</h3>
        <p class="text-gray-400 text-sm">Peringkat #1 setiap bulan berhak mendapatkan bonus insentif dan sertifikat penghargaan.</p>
    </div>
    <button class="relative z-10 px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl uppercase tracking-widest text-xs hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-900/20">
        Buka Detail Reward
    </button>
    <i class="fas fa-gift absolute -bottom-8 -left-8 text-[150px] text-white/5"></i>
</div>
@endsection
