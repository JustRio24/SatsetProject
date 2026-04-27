@extends('layouts.korlap', ['title' => 'Absensi Anak Buah'])

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Session Alert --}}
    @if(session('success'))
    <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-3xl animate-fade-in-up">
        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shrink-0">
            <i class="fas fa-check"></i>
        </div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        <div class="p-8 border-b border-slate-50">
            <h2 class="font-black text-slate-800 uppercase tracking-tighter italic text-xl">Input Kehadiran Lapangan</h2>
            <p class="text-sm text-slate-400 font-medium mt-1">Pilih personil dan status kehadirannya hari ini.</p>
        </div>
        
        <form action="{{ route('korlap.attendance.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Nama Personil</label>
                    <select name="worker_id" required class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none font-bold text-sm bg-white shadow-sm">
                        <option value="">Pilih Anak Buah...</option>
                        @foreach($subordinates as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                        @endforeach
                    </select>
                    @error('worker_id')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Status Kehadiran</label>
                    <select name="status" required class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none font-bold text-sm bg-white shadow-sm">
                        <option value="hadir">✅ Hadir</option>
                        <option value="izin">📋 Izin</option>
                        <option value="sakit">🏥 Sakit</option>
                        <option value="alpa">❌ Alpa / Tanpa Keterangan</option>
                    </select>
                </div>
            </div>

            {{-- Photo Upload --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Foto Bukti Kehadiran</label>
                <div class="relative group cursor-pointer" id="photo_drop_zone">
                    <input type="file" name="photo" accept="image/*" capture="environment" id="photo_input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div id="photo_preview_container" class="border-2 border-dashed border-slate-200 rounded-3xl p-10 flex flex-col items-center justify-center text-slate-400 group-hover:border-red-500 group-hover:text-red-500 group-hover:bg-red-50 transition-all duration-300">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-red-100 transition-all">
                            <i class="fas fa-camera"></i>
                        </div>
                        <span class="text-sm font-bold" id="filename_display">Ketuk untuk Ambil Foto / Pilih File</span>
                        <span class="text-[10px] mt-1 uppercase tracking-widest">JPG, PNG, WEBP • Max 2MB</span>
                    </div>
                    <img id="photo_preview" src="" alt="Preview" class="hidden w-full max-h-64 object-cover rounded-3xl">
                </div>
            </div>

            {{-- GPS Location --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Lokasi GPS Otomatis</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative">
                        <i class="fas fa-map-pin absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="text" name="lat" id="lat" readonly class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-100 bg-slate-50 text-slate-600 text-sm outline-none font-bold" placeholder="Mendeteksi latitude...">
                    </div>
                    <div class="relative">
                        <i class="fas fa-map-pin absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input type="text" name="long" id="long" readonly class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-100 bg-slate-50 text-slate-600 text-sm outline-none font-bold" placeholder="Mendeteksi longitude...">
                    </div>
                </div>
                <p id="gps_status" class="text-[10px] font-bold text-slate-400 mt-2 ml-2">
                    <i class="fas fa-satellite-dish mr-1"></i> Menunggu izin GPS...
                </p>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Catatan Tambahan <span class="text-slate-300">(Opsional)</span></label>
                <textarea name="notes" rows="3" class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none font-medium text-sm bg-white shadow-sm resize-none" placeholder="Tulis catatan jika ada kendala, izin mendadak, atau keterangan lainnya..."></textarea>
            </div>

            <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-red-500/20 hover:bg-red-700 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-save"></i> Simpan Data Absensi
            </button>
        </form>
    </div>

    {{-- Today's Attendance Log --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up delay-100">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <div>
                <h3 class="font-black text-slate-800 uppercase tracking-tighter italic">Log Absensi Hari Ini</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ now()->format('l, d F Y') }}</p>
            </div>
            <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-[10px] font-black uppercase tracking-widest">Live</span>
        </div>
        <div class="p-6">
            <p class="text-slate-400 text-center text-sm font-bold py-8 uppercase tracking-widest"><i class="fas fa-clipboard-list mr-2"></i>Log absensi hari ini akan muncul di sini.</p>
        </div>
    </div>
</div>

<script>
    // Enhanced GPS detection
    const gpsStatus = document.getElementById('gps_status');
    if (navigator.geolocation) {
        gpsStatus.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mendeteksi lokasi GPS...';
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('lat').value = position.coords.latitude.toFixed(7);
                document.getElementById('long').value = position.coords.longitude.toFixed(7);
                gpsStatus.innerHTML = '<i class="fas fa-check-circle text-emerald-500 mr-1"></i> <span class="text-emerald-600">Lokasi berhasil dideteksi.</span>';
            },
            function(err) {
                gpsStatus.innerHTML = '<i class="fas fa-exclamation-triangle text-amber-500 mr-1"></i> <span class="text-amber-600">Izin GPS ditolak. Isi manual atau aktifkan GPS.</span>';
            }
        );
    } else {
        gpsStatus.innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i> <span class="text-red-500">Browser tidak mendukung GPS.</span>';
    }

    // Photo preview
    const photoInput = document.getElementById('photo_input');
    const photoPreview = document.getElementById('photo_preview');
    const previewContainer = document.getElementById('photo_preview_container');
    const filenameDisplay = document.getElementById('filename_display');

    photoInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            filenameDisplay.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.classList.remove('hidden');
                previewContainer.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
