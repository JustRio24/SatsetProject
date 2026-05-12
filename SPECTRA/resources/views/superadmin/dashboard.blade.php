@extends('layouts.superadmin', ['title' => 'System Overview'])

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        <!-- Total Users -->
        <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-2xl shadow-indigo-600/30 relative overflow-hidden group animate-fade-in-up">
            <p class="text-indigo-200 text-[10px] font-bold uppercase tracking-widest mb-2">Total System Users</p>
            <h3 class="text-5xl font-black">{{ $stats['total_users'] }}</h3>
            <i class="fas fa-users absolute -bottom-4 -right-4 text-7xl text-white/10 group-hover:scale-110 transition-transform"></i>
        </div>

        <!-- Direksi -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 relative group animate-fade-in-up delay-100 hover:border-amber-400 transition-all">
            <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-amber-500 group-hover:text-white transition-all">
                <i class="fas fa-user-tie"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Board of Directors</p>
            <h4 class="text-3xl font-black text-slate-900">{{ $stats['total_direksi'] }} <span class="text-sm text-slate-400">Akun</span></h4>
        </div>

        <!-- GM -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 relative group animate-fade-in-up delay-100 hover:border-emerald-400 transition-all">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <i class="fas fa-sitemap"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">General Managers</p>
            <h4 class="text-3xl font-black text-slate-900">{{ $stats['total_gm'] }} <span class="text-sm text-slate-400">Akun</span></h4>
        </div>

        <!-- Manager Area -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 relative group animate-fade-in-up delay-100 hover:border-blue-400 transition-all">
            <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-500 group-hover:text-white transition-all">
                <i class="fas fa-map-location-dot"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Manager Area</p>
            <h4 class="text-3xl font-black text-slate-900">{{ $stats['total_manager'] }} <span class="text-sm text-slate-400">Akun</span></h4>
        </div>

        <!-- Korlap -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 relative group animate-fade-in-up delay-200 hover:border-red-400 transition-all">
            <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-red-500 group-hover:text-white transition-all">
                <i class="fas fa-users-gear"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Korlap</p>
            <h4 class="text-3xl font-black text-slate-900">{{ $stats['total_korlap'] }} <span class="text-sm text-slate-400">Akun</span></h4>
        </div>

        <!-- Worker -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 relative group animate-fade-in-up delay-200 hover:border-slate-400 transition-all">
            <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-slate-600 group-hover:text-white transition-all">
                <i class="fas fa-helmet-safety"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pekerja Lapangan</p>
            <h4 class="text-3xl font-black text-slate-900">{{ $stats['total_worker'] }} <span class="text-sm text-slate-400">Akun</span></h4>
        </div>
    </div>

    <div class="mt-8 bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200/40 border border-slate-50 text-center animate-fade-in-up delay-300">
        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center text-4xl text-indigo-500 mx-auto mb-6">
            <i class="fas fa-shield-check"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-800 mb-2">Sistem Konfigurasi Utama Aktif</h3>
        <p class="text-slate-500 max-w-xl mx-auto">Anda memiliki akses penuh ke seluruh manajemen pengguna, role, dan pengaturan inti aplikasi SPECTRA. Harap gunakan akses ini dengan bijak.</p>
        
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('superadmin.users') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-black transition-all shadow-xl shadow-slate-900/20">
                Kelola Pengguna
            </a>
            <a href="{{ route('superadmin.users.create') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/30">
                Tambah Akun Baru
            </a>
        </div>
    </div>
</div>
@endsection
