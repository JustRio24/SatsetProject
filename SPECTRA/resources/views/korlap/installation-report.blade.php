@extends('layouts.korlap', ['title' => 'Laporan Hasil Instalasi (Entertainment)'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gradient-to-r from-red-600 to-red-500 text-white">
            <h3 class="font-bold text-lg">Form Khusus Instalasi Rumah/Apt</h3>
            <p class="text-sm text-white/80">Wajib diisi setelah melakukan pemasangan perangkat.</p>
        </div>
        
        <form action="{{ route('korlap.installation-report.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Unit / Alamat</label>
                    <input type="text" name="unit_number" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none" placeholder="Contoh: Apt. Medit Tower A 12-B">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil Test Sinyal</label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="signal_strength" required class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none" placeholder="Contoh: -18 dBm">
                        <span class="text-sm font-bold text-gray-500">dBm</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Hasil Pemasangan <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <input type="file" name="photo" required accept="image/*" id="inst_photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-gray-400 group-hover:border-red-500 group-hover:text-red-500 transition-all">
                        <i class="fas fa-satellite-dish text-3xl mb-2"></i>
                        <span class="text-sm font-medium" id="inst_filename">Upload Foto Bukti Terpasang</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Pemasangan</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none" placeholder="Tuliskan jika ada kendala saat instalasi..."></textarea>
            </div>

            <button type="submit" class="w-full bg-slate-800 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-slate-900 transition-all transform active:scale-95">
                Simpan & Kirim Laporan Instalasi
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('inst_photo').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            document.getElementById('inst_filename').textContent = e.target.files[0].name;
        }
    });
</script>
@endsection
