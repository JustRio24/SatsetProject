@extends('layouts.manager', ['title' => 'Monitoring Lapangan'])

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="font-black text-3xl text-slate-900 uppercase tracking-tighter italic leading-none">Monitoring Lapangan</h2>
            <p class="text-slate-400 text-sm font-medium mt-1">Pantau progres fisik dan kendala dari lapangan secara real-time.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-5 py-2.5 bg-white border border-slate-100 rounded-2xl text-sm font-black text-slate-600 hover:bg-slate-50 shadow-sm transition-all uppercase tracking-widest">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($reports as $report)
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden group hover:-translate-y-1 transition-all duration-500 animate-fade-in-up">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $report->photo) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400?text=Foto+Laporan'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                        <span class="px-3 py-1 bg-black/40 backdrop-blur-md text-white text-[9px] font-black rounded-xl uppercase tracking-wider">
                            {{ $report->project_name ?? 'Proyek Umum' }}
                        </span>
                        <span class="text-white text-[9px] font-bold opacity-80">{{ \Carbon\Carbon::parse($report->created_at)->format('d M') }}</span>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($report->korlap_name) }}&background=ef4444&color=fff&bold=true" class="w-9 h-9 rounded-xl border-2 border-red-100 shadow-sm">
                        <div class="min-w-0">
                            <p class="text-xs font-black text-slate-800 leading-none truncate">{{ $report->korlap_name }}</p>
                            <p class="text-[9px] text-slate-400 mt-0.5 uppercase font-bold">{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">Progres</h4>
                        <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $report->progress }}</p>
                    </div>
                    
                    @if($report->obstacles)
                        <div class="p-4 bg-red-50 rounded-2xl border border-red-100">
                            <h4 class="text-[9px] font-black text-red-600 uppercase tracking-widest mb-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-triangle"></i> Kendala Dilaporkan
                            </h4>
                            <p class="text-xs text-red-700 leading-relaxed">{{ $report->obstacles }}</p>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-[9px] font-black text-emerald-600 uppercase tracking-widest">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Tidak Ada Kendala
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-100 shadow-sm">
                <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6 text-4xl text-slate-300">
                    <i class="fas fa-camera"></i>
                </div>
                <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Belum ada laporan dari lapangan hari ini.</p>
                <p class="text-slate-300 font-medium text-xs mt-1">Korlap akan mengirim laporan setelah selesai bekerja.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
