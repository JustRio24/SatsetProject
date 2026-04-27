@extends('layouts.direksi', ['title' => 'SDM & Legalitas Perusahaan'])

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
    <!-- Left Column: Legal Documents -->
    <div class="xl:col-span-2 space-y-10">
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Arsip Legalitas & Perizinan</h3>
                <button onclick="document.getElementById('uploadLegalModal').classList.remove('hidden')" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest">Unggah Dokumen</button>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Judul Dokumen</th>
                            <th class="px-8 py-5">Kategori</th>
                            <th class="px-8 py-5">Tgl Kedaluwarsa</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-6">
                                    <p class="text-sm font-black text-slate-800 leading-none">{{ $doc->title }}</p>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold">Uploaded {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y') }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase">{{ $doc->category }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-bold text-slate-600">{{ $doc->expiry_date ?? 'N/A' }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-slate-900 hover:text-amber-500 transition-colors">
                                        <i class="fas fa-file-pdf text-xl"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-slate-400 text-xs font-bold uppercase">Belum ada dokumen legalitas terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Database Seluruh Karyawan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Nama / Posisi</th>
                            <th class="px-8 py-5">Role</th>
                            <th class="px-8 py-5">Area Kerja</th>
                            <th class="px-8 py-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($employees as $emp)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-6 flex items-center gap-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}" class="w-10 h-10 rounded-xl">
                                    <div>
                                        <p class="text-sm font-black text-slate-800 leading-none">{{ $emp->name }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold">{{ $emp->position ?? 'Staff' }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">{{ $emp->role }}</span>
                                </td>
                                <td class="px-8 py-6 text-xs font-bold text-slate-600">{{ $emp->area ?? 'Nasional' }}</td>
                                <td class="px-8 py-6 text-right">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase">Active</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Stats & Alerts -->
    <div class="space-y-8">
        <div class="bg-indigo-900 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden">
            <h4 class="font-black text-lg uppercase tracking-widest mb-6">Health Check Legal</h4>
            <div class="space-y-6">
                <div class="flex justify-between items-center p-4 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-xs font-bold text-indigo-300 uppercase">Kepatuhan Hukum</span>
                    <span class="text-emerald-400 font-black">100%</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-white/5 rounded-2xl border border-white/10">
                    <span class="text-xs font-bold text-indigo-300 uppercase">Dokumen Expiring</span>
                    <span class="text-amber-400 font-black">2</span>
                </div>
            </div>
            <i class="fas fa-shield-halved absolute -bottom-4 -right-4 text-7xl text-white/5"></i>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-50">
            <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-6">Info SDM Terbaru</h4>
            <div class="space-y-4">
                <div class="flex gap-4 p-4 bg-slate-50 rounded-2xl">
                    <i class="fas fa-user-plus text-indigo-600"></i>
                    <div>
                        <p class="text-xs font-black text-slate-800">Recruitment Baru</p>
                        <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">Divisi Bangunan - Area Semarang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Legal Modal -->
<div id="uploadLegalModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden z-[100] flex items-center justify-center p-6">
    <div class="bg-white rounded-[2.5rem] w-full max-w-lg overflow-hidden shadow-2xl">
        <div class="p-8 bg-slate-900 text-white flex justify-between items-center">
            <h3 class="font-black uppercase tracking-widest text-lg">Unggah Dokumen Legalitas</h3>
            <button onclick="document.getElementById('uploadLegalModal').classList.add('hidden')" class="text-white hover:rotate-90 transition-transform"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('direksi.sdm-legal.upload') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen</label>
                <input type="text" name="title" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-amber-400 outline-none font-bold text-sm">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                <select name="category" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-amber-400 outline-none font-bold text-sm">
                    <option value="Kontrak Kerja">Kontrak Kerja</option>
                    <option value="Perizinan">Perizinan (SIUP/NIB/dll)</option>
                    <option value="Sertifikasi">Sertifikasi Perusahaan</option>
                    <option value="Legalitas Klien">Legalitas Klien Besar</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih File (PDF/Doc)</label>
                <input type="file" name="file" required class="w-full text-xs font-bold text-slate-500">
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-[1.5rem] shadow-xl hover:bg-black transition-all transform active:scale-95 uppercase tracking-widest text-xs">
                Simpan Ke Arsip Digital
            </button>
        </form>
    </div>
</div>
@endsection
