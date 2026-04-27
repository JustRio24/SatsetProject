@extends('layouts.manager', ['title' => 'Monitoring Lapangan'])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="font-bold text-xl text-gray-800">Laporan Harian Korlap</h3>
            <p class="text-sm text-gray-500">Memantau progres fisik dan kendala dari lapangan secara real-time.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50">Filter Proyek</button>
            <button class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50">Filter Tanggal</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($reports as $report)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $report->photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://placehold.co/400x300?text=Foto+Laporan'">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-black/50 backdrop-blur-md text-white text-[10px] font-bold rounded-full uppercase tracking-wider">
                            {{ $report->project_name ?? 'Proyek Umum' }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($report->korlap_name) }}" class="w-8 h-8 rounded-full border border-blue-500">
                        <div>
                            <p class="text-xs font-bold text-gray-800 leading-none">{{ $report->korlap_name }}</p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase">{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-blue-600 uppercase mb-1">Progres</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $report->progress }}</p>
                        </div>
                        
                        @if($report->obstacles)
                            <div class="p-3 bg-red-50 rounded-xl border border-red-100">
                                <h4 class="text-xs font-bold text-red-600 uppercase mb-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-triangle"></i> Kendala
                                </h4>
                                <p class="text-xs text-red-700 leading-relaxed">{{ $report->obstacles }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <i class="fas fa-camera text-5xl text-gray-200 mb-4"></i>
                <p class="text-gray-400 font-medium">Belum ada laporan foto dari lapangan hari ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
