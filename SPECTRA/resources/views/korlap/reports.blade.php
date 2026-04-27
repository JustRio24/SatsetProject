@extends('layouts.korlap', ['title' => 'Laporan Progres Harian'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Buat Laporan Baru</h3>
            <p class="text-sm text-gray-500">Laporkan progres pekerjaan di lapangan hari ini.</p>
        </div>
        
        <form action="{{ route('korlap.reports.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Progres Pekerjaan <span class="text-red-500">*</span></label>
                <textarea name="progress" required rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none" placeholder="Ceritakan progres hari ini secara singkat..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kendala / Masalah (Opsional)</label>
                <textarea name="obstacles" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none" placeholder="Tuliskan kendala jika ada..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Dokumentasi <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <input type="file" name="photo" required accept="image/*" id="report_photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-gray-400 group-hover:border-red-500 group-hover:text-red-500 transition-all">
                        <i class="fas fa-image text-3xl mb-2"></i>
                        <span class="text-sm font-medium" id="report_filename">Wajib Upload Foto Dokumentasi</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-red-200 hover:bg-red-700 transition-all transform active:scale-95">
                Kirim Laporan Progres
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('report_photo').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            document.getElementById('report_filename').textContent = e.target.files[0].name;
        }
    });
</script>
@endsection
