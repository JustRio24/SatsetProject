@extends('layouts.superadmin', ['title' => 'Manajemen Pengguna'])

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-6 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 animate-fade-in-up">
        <form action="{{ route('superadmin.users') }}" method="GET" class="flex flex-wrap gap-4 w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau area..." class="flex-1 px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
            
            <select name="role" class="px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                <option value="">Semua Role</option>
                @foreach($roles as $key => $label)
                    <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-black transition-all shadow-lg shadow-slate-900/20">
                <i class="fas fa-search mr-2"></i> Filter
            </button>
            <a href="{{ route('superadmin.users') }}" class="px-5 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all">
                Reset
            </a>
        </form>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('superadmin.users.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl text-sm font-black hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up delay-100">
        <div class="overflow-x-auto p-4 sm:p-0">
            <table class="w-full text-left min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Role</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Area / Divisi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Terdaftar</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $user->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="w-12 h-12 rounded-2xl shadow-md border-2 border-white" alt="Profile">
                                    <div>
                                        <p class="text-sm font-black text-slate-800 leading-none mb-1">{{ $user->name }}</p>
                                        <p class="text-xs font-medium text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ $roles[$user->role] ?? $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($user->area)
                                    <p class="text-xs font-bold text-slate-700 mb-1"><i class="fas fa-map-marker-alt text-slate-400 mr-1"></i> {{ $user->area }}</p>
                                @endif
                                @if($user->business_line)
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $user->business_line }}</p>
                                @endif
                                @if($user->position)
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $user->position }}</p>
                                @endif
                                @if(!$user->area && !$user->business_line && !$user->position)
                                    <span class="text-slate-400 text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-bold text-slate-600">{{ $user->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $user->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superadmin.users.edit', $user->id) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed" title="Anda tidak bisa menghapus akun Anda sendiri">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl text-slate-300">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Tidak ada pengguna yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="p-6 border-t border-slate-50 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
