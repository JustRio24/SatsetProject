@extends('layouts.korlap', ['title' => 'Gaji & Hasil Bagi'])

@section('content')
<div class="space-y-8">

    {{-- Hero Summary Card --}}
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative overflow-hidden animate-fade-in-up">
        <div class="relative z-10">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3"><i class="fas fa-coins mr-2"></i>Total Akumulasi Penghasilan</p>
            <h3 class="text-5xl font-black leading-none">Rp {{ number_format($salaries->sum('amount'), 0, ',', '.') }}</h3>
            <div class="flex items-center gap-2 mt-4">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <p class="text-emerald-400 text-xs font-bold uppercase tracking-widest">{{ $salaries->where('status', 'paid')->count() }} Transaksi Terverifikasi</p>
            </div>
        </div>
        <div class="relative z-10 w-full sm:w-auto">
            <a href="https://wa.me/6281234567890?text=Halo+Admin,+saya+ingin+menanyakan+tentang+gaji+saya." target="_blank"
               class="w-full sm:w-auto flex items-center justify-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black py-3.5 px-8 rounded-2xl transition-all shadow-xl shadow-emerald-900/30 text-sm uppercase tracking-widest">
                <i class="fab fa-whatsapp text-lg"></i> Hubungi Admin Gaji
            </a>
        </div>
        <i class="fas fa-vault absolute -bottom-8 -right-8 text-[180px] text-white/[0.03]"></i>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 animate-fade-in-up delay-100">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-50 shadow-xl shadow-slate-200/50 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl"><i class="fas fa-money-bill-wave"></i></div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gaji Pokok</p>
                <p class="text-xl font-black text-slate-800">Rp {{ number_format($salaries->where('type', 'gaji')->sum('amount'), 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-50 shadow-xl shadow-slate-200/50 flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl"><i class="fas fa-percent"></i></div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bagi Hasil</p>
                <p class="text-xl font-black text-slate-800">Rp {{ number_format($salaries->where('type', 'bagi_hasil')->sum('amount'), 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-50 shadow-xl shadow-slate-200/50 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl"><i class="fas fa-check-circle"></i></div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Terakhir</p>
                <p class="text-xl font-black text-emerald-600 uppercase">{{ $salaries->count() > 0 ? $salaries->first()->status : 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- Salary History Table --}}
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up delay-200">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <div>
                <h3 class="font-black text-slate-800 uppercase tracking-tighter italic text-xl">Riwayat Pembayaran</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Seluruh catatan transaksi gaji & bagi hasil Anda</p>
            </div>
            <span class="px-4 py-2 bg-slate-50 text-slate-500 text-[10px] font-black rounded-2xl uppercase tracking-widest">{{ $salaries->count() }} Transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[500px]">
                <thead>
                    <tr class="bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-8 py-5">Tanggal</th>
                        <th class="px-8 py-5">Jenis</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($salaries as $salary)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $salary->type === 'gaji' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $salary->type === 'gaji' ? '💰 Gaji Pokok' : '📊 Bagi Hasil' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                @if($salary->status === 'paid')
                                    <span class="flex items-center gap-2 text-[10px] font-black text-emerald-600 uppercase">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Lunas
                                    </span>
                                @else
                                    <span class="flex items-center gap-2 text-[10px] font-black text-amber-600 uppercase">
                                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-lg font-black text-slate-900">Rp {{ number_format($salary->amount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl text-slate-300">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Belum ada data pembayaran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
