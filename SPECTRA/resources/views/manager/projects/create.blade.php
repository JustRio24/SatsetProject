@extends('layouts.manager', ['title' => 'Input Proyek Baru'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gradient-to-r from-blue-600 to-blue-500 text-white">
            <h3 class="font-bold text-xl">Registrasi Hasil Closing Deal</h3>
            <p class="text-blue-100 text-sm">Masukkan detail kontrak untuk proyek di wilayah {{ auth()->user()->area }}.</p>
        </div>
        
        <form action="{{ route('manager.projects.store') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Proyek</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Contoh: Renovasi Kantor BRI">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Klien</label>
                    <input type="text" name="client_name" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Nama Perusahaan atau Personal">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="service_type" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        <option value="Bangunan">Bangunan</option>
                        <option value="Bengkel">Bengkel</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Antrian">Antrian</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Kontrak (Rp)</label>
                    <input type="number" name="contract_value" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                    <input type="text" name="duration" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Contoh: 3 Bulan">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Detail Pekerjaan</label>
                <textarea name="details" rows="5" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Deskripsikan ruang lingkup pekerjaan..."></textarea>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('manager.projects.index') }}" class="flex-1 text-center py-4 rounded-2xl border border-gray-200 font-bold text-gray-500 hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="flex-[2] bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all transform active:scale-95">
                    Simpan Proyek & Closing Deal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
