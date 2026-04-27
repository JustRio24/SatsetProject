@extends('layouts.korlap', ['title' => 'Absensi Anak Buah'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Input Kehadiran Lapangan</h3>
            <p class="text-sm text-gray-500">Pilih personil dan status kehadirannya.</p>
        </div>
        
        <form action="{{ route('korlap.attendance.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Personil</label>
                    <select name="worker_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none">
                        <option value="">Pilih Anak Buah...</option>
                        @foreach($subordinates as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Kehadiran</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none">
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpa">Alpa / Tanpa Keterangan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Lokasi / Bukti</label>
                <div class="relative group">
                    <input type="file" name="photo" accept="image/*" id="photo_input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-gray-400 group-hover:border-red-500 group-hover:text-red-500 transition-all">
                        <i class="fas fa-camera text-3xl mb-2"></i>
                        <span class="text-sm font-medium" id="filename_display">Ambil Foto atau Pilih File</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Koordinat Latitude (Opsional)</label>
                    <input type="text" name="lat" id="lat" readonly class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 text-sm outline-none" placeholder="Otomatis terisi...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Koordinat Longitude (Opsional)</label>
                    <input type="text" name="long" id="long" readonly class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 text-sm outline-none" placeholder="Otomatis terisi...">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all outline-none" placeholder="Tulis catatan jika ada (opsional)..."></textarea>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-red-200 hover:bg-red-700 transition-all transform active:scale-95">
                Simpan Data Absensi
            </button>
        </form>
    </div>
</div>

<script>
    // Simple script to get GPS location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('long').value = position.coords.longitude;
        });
    }

    // Display filename
    document.getElementById('photo_input').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            document.getElementById('filename_display').textContent = e.target.files[0].name;
        }
    });
</script>
@endsection
