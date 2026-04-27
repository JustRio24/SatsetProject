@extends('layouts.manager', ['title' => 'Input Proyek Baru'])

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    @if(session('success'))
    <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-3xl animate-fade-in-up">
        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shrink-0"><i class="fas fa-check"></i></div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        {{-- Header --}}
        <div class="p-8 bg-gradient-to-r from-blue-700 to-blue-600 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-2xl border border-white/20">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl uppercase tracking-tighter leading-none">Registrasi Closing Deal</h2>
                        <p class="text-blue-200 text-xs font-bold uppercase tracking-widest">Area: {{ auth()->user()->area }}</p>
                    </div>
                </div>
                <p class="text-blue-100 text-sm mt-4 max-w-xl">Catat detail kontrak yang telah berhasil ditutup. Data ini akan langsung mengalir ke sistem kalkulasi bagi hasil.</p>
            </div>
            <i class="fas fa-file-contract absolute -bottom-8 -right-8 text-[160px] text-white/5"></i>
        </div>
        
        <form action="{{ route('manager.projects.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            {{-- Row 1: Project & Client Name --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Nama Proyek <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-bold text-sm shadow-sm"
                        placeholder="Contoh: Renovasi Kantor BRI Semarang">
                    @error('name')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Nama Klien <span class="text-red-500">*</span></label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" required
                        class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-bold text-sm shadow-sm"
                        placeholder="Nama Perusahaan atau Personal">
                    @error('client_name')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Row 2: Service Type, Contract Value, Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Jenis Layanan <span class="text-red-500">*</span></label>
                    <select name="service_type" required class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none font-bold text-sm bg-white shadow-sm">
                        <option value="Bangunan" {{ old('service_type') == 'Bangunan' ? 'selected' : '' }}>🏗️ Bangunan / Konstruksi</option>
                        <option value="Bengkel" {{ old('service_type') == 'Bengkel' ? 'selected' : '' }}>🔧 Bengkel Terpadu</option>
                        <option value="Entertainment" {{ old('service_type') == 'Entertainment' ? 'selected' : '' }}>📺 Entertainment & Tech</option>
                        <option value="Antrian" {{ old('service_type') == 'Antrian' ? 'selected' : '' }}>🎟️ Sistem Antrian</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Nilai Kontrak (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-black text-sm">Rp</span>
                        <input type="number" name="contract_value" value="{{ old('contract_value') }}" required
                            class="w-full pl-12 pr-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-bold text-sm shadow-sm"
                            placeholder="0" min="0">
                    </div>
                    @error('contract_value')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Estimasi Durasi <span class="text-red-500">*</span></label>
                    <input type="text" name="duration" value="{{ old('duration') }}" required
                        class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-bold text-sm shadow-sm"
                        placeholder="Contoh: 3 Bulan">
                    @error('duration')<p class="text-[10px] text-red-500 font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Revenue Split Preview --}}
            <div id="split_preview" class="p-6 bg-blue-50 rounded-3xl border border-blue-100 hidden">
                <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4"><i class="fas fa-calculator mr-2"></i>Kalkulasi Otomatis Skema 5:3:1:1</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-white rounded-2xl shadow-sm">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Pekerja (50%)</p>
                        <p class="text-lg font-black text-slate-800 mt-1" id="worker_share">Rp 0</p>
                    </div>
                    <div class="text-center p-3 bg-white rounded-2xl shadow-sm">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">PT (30%)</p>
                        <p class="text-lg font-black text-slate-800 mt-1" id="company_share">Rp 0</p>
                    </div>
                    <div class="text-center p-3 bg-white rounded-2xl shadow-sm">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Korlap (10%)</p>
                        <p class="text-lg font-black text-blue-600 mt-1" id="korlap_share">Rp 0</p>
                    </div>
                    <div class="text-center p-3 bg-blue-600 rounded-2xl shadow-sm">
                        <p class="text-[8px] font-black text-white/70 uppercase tracking-widest">Anda (10%)</p>
                        <p class="text-lg font-black text-white mt-1" id="manager_share">Rp 0</p>
                    </div>
                </div>
            </div>

            {{-- Detail --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-3">Detail Pekerjaan</label>
                <textarea name="details" rows="5" class="w-full px-6 py-4 rounded-2xl border border-slate-100 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-medium text-sm resize-none shadow-sm" placeholder="Deskripsikan ruang lingkup pekerjaan secara lengkap...">{{ old('details') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ url()->previous() }}" class="flex-1 text-center py-4 rounded-2xl border border-slate-200 font-black text-slate-500 hover:bg-slate-50 transition-all text-sm uppercase tracking-widest">
                    <i class="fas fa-arrow-left mr-2"></i> Batal
                </a>
                <button type="submit" class="flex-[2] bg-blue-600 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95 text-sm uppercase tracking-widest">
                    <i class="fas fa-save mr-2"></i> Simpan Proyek & Closing Deal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Live revenue split calculator
    const contractInput = document.querySelector('input[name="contract_value"]');
    const splitPreview = document.getElementById('split_preview');

    function formatRp(num) {
        return 'Rp ' + Math.round(num).toLocaleString('id-ID');
    }

    contractInput.addEventListener('input', function() {
        const val = parseFloat(this.value) || 0;
        if (val > 0) {
            splitPreview.classList.remove('hidden');
            document.getElementById('worker_share').textContent = formatRp(val * 0.5);
            document.getElementById('company_share').textContent = formatRp(val * 0.3);
            document.getElementById('korlap_share').textContent = formatRp(val * 0.1);
            document.getElementById('manager_share').textContent = formatRp(val * 0.1);
        } else {
            splitPreview.classList.add('hidden');
        }
    });
</script>
@endsection
