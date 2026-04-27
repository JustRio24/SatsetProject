@extends('layouts.finance', ['title' => 'Realisasi Payout'])

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-indigo-50/30">
            <div>
                <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Menunggu Realisasi Pembayaran</h3>
                <p class="text-xs text-slate-500 mt-1">Daftar payout yang sudah disetujui oleh Manager Area.</p>
            </div>
            <i class="fas fa-money-bill-transfer text-indigo-200 text-3xl"></i>
        </div>
        <div class="p-0 overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="px-8 py-5">Penerima / Role</th>
                        <th class="px-8 py-5">Proyek</th>
                        <th class="px-8 py-5">Jenis</th>
                        <th class="px-8 py-5">Jumlah</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payouts as $payout)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-slate-800 leading-none">{{ $payout->user_name }}</p>
                                <p class="text-[10px] text-indigo-600 mt-1 uppercase font-bold">{{ $payout->user_role }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-bold text-slate-600">{{ $payout->project_name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase">{{ $payout->type }}</span>
                            </td>
                            <td class="px-8 py-6 text-sm font-black text-slate-900">
                                Rp {{ number_format($payout->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('finance.payouts.realize', $payout->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black rounded-xl uppercase hover:bg-emerald-700 transition-all shadow-md">
                                        Realisasi Bayar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">
                                Tidak ada payout yang menunggu realisasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
