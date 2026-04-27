@extends('layouts.direksi', ['title' => 'Pengaturan Gamifikasi Perusahaan'])

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
    <!-- Left Column: Settings -->
    <div class="xl:col-span-1 space-y-10">
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-50 overflow-hidden">
            <div class="p-8 bg-slate-900 text-white">
                <h3 class="font-black uppercase tracking-widest text-sm">Bobot Poin KPI</h3>
                <p class="text-slate-400 text-[10px] mt-1">Atur seberapa besar pengaruh setiap aksi terhadap skor.</p>
            </div>
            <div class="p-8 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Laporan Tepat Waktu</label>
                    <div class="flex items-center gap-4">
                        <input type="range" class="flex-1 accent-amber-400" min="1" max="100" value="40">
                        <span class="text-sm font-black text-slate-900">40%</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kehadiran Anggota</label>
                    <div class="flex items-center gap-4">
                        <input type="range" class="flex-1 accent-amber-400" min="1" max="100" value="30">
                        <span class="text-sm font-black text-slate-900">30%</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kepuasan Klien</label>
                    <div class="flex items-center gap-4">
                        <input type="range" class="flex-1 accent-amber-400" min="1" max="100" value="30">
                        <span class="text-sm font-black text-slate-900">30%</span>
                    </div>
                </div>
                <button class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all">
                    Simpan Konfigurasi
                </button>
            </div>
        </div>

        <div class="bg-indigo-900 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden">
            <h4 class="font-black text-lg uppercase tracking-widest mb-4">Pengingat Otomatis</h4>
            <p class="text-indigo-300 text-xs leading-relaxed mb-6">
                Sistem akan mengirimkan notifikasi push setiap Senin pagi pukul 08:00 WIB untuk memberitahu peringkat terbaru.
            </p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-6 bg-amber-400 rounded-full flex items-center px-1">
                    <div class="w-4 h-4 bg-white rounded-full ml-auto shadow-sm"></div>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest">Notifikasi Aktif</span>
            </div>
            <i class="fas fa-bell absolute -bottom-4 -right-4 text-7xl text-white/5"></i>
        </div>
    </div>

    <!-- Right Column: Badges Master -->
    <div class="xl:col-span-2">
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-50 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Master Lencana (Badges)</h3>
                <button class="px-4 py-2 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest">Tambah Lencana</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Lencana</th>
                            <th class="px-8 py-5">Syarat (KPI)</th>
                            <th class="px-8 py-5">Jumlah Peraih</th>
                            <th class="px-8 py-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($badges as $badge)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-6 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl" style="background: {{ $badge->color }}20; color: {{ $badge->color }}">
                                        <i class="fas {{ $badge->icon }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 leading-none">{{ $badge->name }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold">{{ $badge->description }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase">{{ $badge->requirement_type }} > {{ $badge->requirement_value }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm font-black text-slate-900">
                                    12 Orang
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase">Active</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-slate-400 text-xs font-bold uppercase">Belum ada lencana yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
