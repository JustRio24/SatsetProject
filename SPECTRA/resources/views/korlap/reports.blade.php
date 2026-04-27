@extends('layouts.korlap', ['title' => 'Laporan Progres Harian'])

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    @if(session('success'))
    <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-3xl animate-fade-in-up">
        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shrink-0"><i class="fas fa-check"></i></div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        <div class="p-8 border-b border-slate-50 bg-slate-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 text-xl">
                    <i class="fas fa-file-pen"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800 uppercase tracking-tighter italic text-xl">Buat Laporan Harian</h2>
                    <p class="text-sm text-slate-400 font-medium">Laporkan progres pekerjaan di lapangan hari ini.</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('korlap.reports.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Progres Pekerjaan <span class="text-red-500">*</span></label>
                <textarea name="progress" required rows="4" class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none font-medium text-sm resize-none shadow-sm" placeholder="Deskripsikan progres hari ini: sudah selesai bagian mana, target besok, dll...">{{ old('progress') }}</textarea>
                @error('progress')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Kendala / Masalah <span class="text-slate-300">(Opsional)</span></label>
                <textarea name="obstacles" rows="3" class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none font-medium text-sm resize-none shadow-sm" placeholder="Tuliskan kendala jika ada, misal: material kurang, cuaca buruk, dll...">{{ old('obstacles') }}</textarea>
            </div>

            {{-- Photo Upload with Preview --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Foto Dokumentasi Lapangan <span class="text-red-500">*</span></label>
                <div class="relative group cursor-pointer">
                    <input type="file" name="photo" required accept="image/*" capture="environment" id="report_photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div id="report_preview_container" class="border-2 border-dashed border-slate-200 rounded-3xl p-10 flex flex-col items-center justify-center text-slate-400 group-hover:border-red-500 group-hover:bg-red-50 transition-all duration-300">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-red-100 transition-all">
                            <i class="fas fa-image"></i>
                        </div>
                        <span class="text-sm font-bold" id="report_filename">Upload Foto Dokumentasi Wajib</span>
                        <span class="text-[10px] mt-1 uppercase tracking-widest text-slate-300">JPG, PNG, WEBP • Max 2MB</span>
                    </div>
                    <img id="report_preview" src="" alt="Preview" class="hidden w-full max-h-80 object-cover rounded-3xl shadow-xl">
                </div>
                @error('photo')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-red-500/20 hover:bg-red-700 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                <i class="fas fa-paper-plane"></i> Kirim Laporan ke Manager
            </button>
        </form>
    </div>
</div>

<script>
    const reportPhoto = document.getElementById('report_photo');
    const reportPreview = document.getElementById('report_preview');
    const reportPreviewContainer = document.getElementById('report_preview_container');
    const reportFilename = document.getElementById('report_filename');

    reportPhoto.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            reportFilename.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                reportPreview.src = e.target.result;
                reportPreview.classList.remove('hidden');
                reportPreviewContainer.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
