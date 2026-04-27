@extends('layouts.manager', ['title' => 'Daftar Proyek Area'])

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="font-black text-3xl text-slate-900 uppercase tracking-tighter italic leading-none">Manajemen Proyek</h2>
            <p class="text-slate-400 text-sm font-medium mt-1">Daftar semua proyek aktif dan riwayat kontrak di Area {{ auth()->user()->area }}.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('manager.projects.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-2xl text-sm font-black hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-plus"></i> Proyek Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-3xl animate-fade-in-up">
        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shrink-0"><i class="fas fa-check"></i></div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        <div class="overflow-x-auto p-4 sm:p-0">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Proyek</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Klien</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Nilai Kontrak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 
                                        {{ $project->service_type == 'Bangunan' ? 'bg-amber-100 text-amber-600' : '' }}
                                        {{ $project->service_type == 'Bengkel' ? 'bg-slate-200 text-slate-700' : '' }}
                                        {{ $project->service_type == 'Entertainment' ? 'bg-purple-100 text-purple-600' : '' }}
                                        {{ $project->service_type == 'Antrian' ? 'bg-blue-100 text-blue-600' : '' }}
                                    ">
                                        @if($project->service_type == 'Bangunan') <i class="fas fa-building"></i>
                                        @elseif($project->service_type == 'Bengkel') <i class="fas fa-wrench"></i>
                                        @elseif($project->service_type == 'Entertainment') <i class="fas fa-music"></i>
                                        @elseif($project->service_type == 'Antrian') <i class="fas fa-users-viewfinder"></i>
                                        @else <i class="fas fa-briefcase"></i> @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 leading-none mb-1">{{ $project->name }}</p>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $project->service_type }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-bold text-slate-700">{{ $project->client_name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg inline-block"><i class="far fa-clock mr-1"></i> {{ $project->duration }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-widest"><i class="fas fa-circle text-[8px] mr-1"></i> Aktif</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <p class="text-sm font-black text-slate-900">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">{{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl text-slate-300">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Belum ada proyek yang terdaftar.</p>
                                <a href="{{ route('manager.projects.create') }}" class="inline-block mt-4 text-xs font-bold text-blue-600 hover:text-blue-700 uppercase tracking-widest">
                                    <i class="fas fa-plus mr-1"></i> Buat Proyek Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
