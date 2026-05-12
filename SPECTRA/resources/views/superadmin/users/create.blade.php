@extends('layouts.superadmin', ['title' => 'Tambah Pengguna Baru'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('superadmin.users') }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengguna
        </a>
    </div>

    <form action="{{ route('superadmin.users.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 p-8 md:p-12 animate-fade-in-up">
        @csrf

        <div class="mb-10 text-center">
            <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800">Informasi Pengguna Baru</h3>
            <p class="text-slate-500 text-sm mt-2">Lengkapi data berikut untuk mendaftarkan akun baru ke dalam sistem.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nama Lengkap -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                @error('name') <p class="text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                @error('email') <p class="text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                @error('password') <p class="text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>

            <!-- Role -->
            <div class="space-y-2 md:col-span-2 mt-4 pt-4 border-t border-slate-100">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akses Role (Peran)</label>
                <select name="role" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 text-sm font-bold text-slate-800 outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role') <p class="text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Field Opsional -->
            <div class="md:col-span-2 space-y-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-4">Atribut Tambahan (Sesuai Role)</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400">Area (Wilayah Kerja)</label>
                        <input type="text" name="area" value="{{ old('area') }}" placeholder="Contoh: Semarang, Jakarta" class="w-full px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400">Lini Bisnis</label>
                        <select name="business_line" class="w-full px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- Tidak Ada --</option>
                            <option value="Bangunan" {{ old('business_line') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                            <option value="Bengkel" {{ old('business_line') == 'Bengkel' ? 'selected' : '' }}>Bengkel</option>
                            <option value="Entertainment" {{ old('business_line') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                            <option value="Antrian" {{ old('business_line') == 'Antrian' ? 'selected' : '' }}>Antrian</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400">Posisi Jabatan Khusus</label>
                        <input type="text" name="position" value="{{ old('position') }}" placeholder="Contoh: Direktur Utama" class="w-full px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 flex justify-end gap-4 border-t border-slate-100 pt-8">
            <a href="{{ route('superadmin.users') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-slate-200 transition-all">
                Batal
            </a>
            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
