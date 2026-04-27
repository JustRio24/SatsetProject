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
<div class="min-h-screen bg-slate-950 py-20 px-4">
    <div class="max-w-7xl mx-auto space-y-20">
        <div class="text-center space-y-4">
            <h1 class="text-6xl font-black text-white uppercase tracking-tighter italic">Digital Wall of Fame</h1>
            <p class="text-amber-400 font-bold uppercase tracking-[0.4em] text-sm">Memberi Penghormatan Bagi yang Berdedikasi</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12">
            @foreach($winners as $winner)
                <div class="group relative">
                    <div class="aspect-[3/4] rounded-[3rem] overflow-hidden border-2 border-white/10 group-hover:border-amber-400/50 transition-all duration-500 shadow-2xl">
                        <img src="{{ $winner->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($winner->name).'&size=512' }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8 text-center">
                            <h4 class="text-xl font-black text-white uppercase tracking-tight">{{ $winner->name }}</h4>
                            <p class="text-[10px] text-amber-400 font-bold uppercase tracking-widest mt-1">{{ $winner->position ?? $winner->role }}</p>
                            <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                <p class="text-xs text-slate-400 italic">"Konsistensi adalah kunci keberhasilan di lapangan."</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-amber-400 rounded-2xl flex items-center justify-center text-slate-900 shadow-xl group-hover:rotate-12 transition-transform">
                        <i class="fas fa-award text-xl"></i>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-20 text-center">
            <div class="inline-block p-10 bg-white/5 backdrop-blur-md rounded-[3rem] border border-white/10 max-w-2xl">
                <h3 class="text-2xl font-black text-white uppercase mb-4 tracking-widest italic">Hall of Fame Eksekutif</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-8">
                    Setiap tahun, kami memilih satu pimpinan terbaik yang berhasil membawa lini bisnisnya melampaui target operasional dan kepuasan klien.
                </p>
                <div class="flex items-center justify-center gap-6">
                    <img src="https://ui-avatars.com/api/?name=Executive+Winner&background=fbbf24&color=0f172a" class="w-20 h-20 rounded-3xl border-4 border-amber-400">
                    <div class="text-left">
                        <p class="text-lg font-black text-white uppercase leading-none">Pak GM Bangunan</p>
                        <p class="text-[10px] text-amber-400 font-bold uppercase mt-1">General Manager of The Year 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
