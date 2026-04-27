@extends('layouts.gm', ['title' => 'Monitoring Nasional Lini ' . auth()->user()->business_line])

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="font-extrabold text-2xl text-gray-800 uppercase tracking-wider">Pengawasan Seluruh Wilayah</h3>
            <p class="text-sm text-gray-500">Melihat detail kinerja tim lapangan dari semua Manager Area.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($reports as $report)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="relative h-48">
                    <img src="{{ asset('storage/' . $report->photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://placehold.co/400x300?text=Laporan+Lapangan'">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-emerald-600/80 backdrop-blur-md text-white text-[10px] font-bold rounded-full uppercase tracking-widest shadow-lg">
                            {{ $report->area }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-extrabold text-gray-800 leading-tight mb-1">{{ $report->project_name }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y | H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-gray-50 rounded-2xl mb-4">
                        <p class="text-xs text-gray-600 italic leading-relaxed">"{{ \Illuminate\Support\Str::limit($report->progress, 120) }}"</p>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-50">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center font-bold text-emerald-600 text-xs">
                            {{ substr($report->korlap_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase leading-none">Reporter Korlap</p>
                            <p class="text-xs font-extrabold text-gray-800 mt-1">{{ $report->korlap_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <i class="fas fa-desktop text-5xl text-gray-200 mb-4"></i>
                <p class="text-gray-400 font-bold uppercase tracking-widest">Belum ada laporan aktivitas dari tim wilayah.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
