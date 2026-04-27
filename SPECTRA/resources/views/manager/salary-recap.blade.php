@extends('layouts.manager', ['title' => 'Rekap Gaji & Bagi Hasil'])

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-bold text-xl text-gray-800">Skema Bagi Hasil (5:3:1:1)</h3>
            <p class="text-sm text-gray-500">Kalkulasi otomatis berdasarkan nilai kontrak proyek aktif.</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('manager.export.payouts') }}" class="bg-white border border-blue-100 text-blue-600 px-6 py-3 rounded-2xl font-bold shadow-lg hover:bg-blue-50 transition-all flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Ekspor Rekap PDF
            </a>
            <form action="{{ route('manager.salary-recap.approve-all') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui semua rekap yang belum disetujui?');">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg hover:bg-green-700 transition-all flex items-center gap-2">
                    <i class="fas fa-check-double"></i> Approve Semua Rekap
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        <div class="p-8 border-b border-slate-50 bg-slate-50/50">
            <h4 class="font-black text-slate-800 uppercase tracking-tighter italic">Daftar Kalkulasi Proyek</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Proyek</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-center">Pekerja (5)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-center">PT (3)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-center">Korlap (1)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-center">Manager (1)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recaps as $recap)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-slate-800">{{ $recap['project_name'] }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Nilai: Rp {{ number_format($recap['total'], 0, ',', '.') }}</p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold text-slate-700">Rp {{ number_format($recap['worker_share'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold text-slate-700">Rp {{ number_format($recap['company_share'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-2 bg-blue-50 rounded-xl text-xs font-bold text-blue-600">Rp {{ number_format($recap['korlap_share'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-2 bg-emerald-50 rounded-xl text-xs font-black text-emerald-600 border border-emerald-100">Rp {{ number_format($recap['manager_share'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if($recap['is_approved'])
                                    <span class="text-green-600 font-bold text-xs uppercase"><i class="fas fa-check-circle"></i> Disetujui</span>
                                @else
                                    <form action="{{ route('manager.salary-recap.approve', $recap['project_id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all">Approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50">
                    <tr class="font-black text-slate-900">
                        <td class="px-8 py-6 uppercase tracking-tighter italic">TOTAL AREA</td>
                        <td class="px-8 py-6 text-center">Rp {{ number_format(collect($recaps)->sum('worker_share'), 0, ',', '.') }}</td>
                        <td class="px-8 py-6 text-center">Rp {{ number_format(collect($recaps)->sum('company_share'), 0, ',', '.') }}</td>
                        <td class="px-8 py-6 text-center">Rp {{ number_format(collect($recaps)->sum('korlap_share'), 0, ',', '.') }}</td>
                        <td class="px-8 py-6 text-center text-emerald-600">Rp {{ number_format(collect($recaps)->sum('manager_share'), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="p-6 bg-yellow-50 border border-yellow-100 rounded-3xl">
        <div class="flex gap-4">
            <i class="fas fa-info-circle text-yellow-600 text-xl"></i>
            <div>
                <p class="text-sm font-bold text-yellow-800">Catatan Skema Streaming</p>
                <p class="text-xs text-yellow-700 mt-1">Untuk proyek entertainment dengan skema streaming, bagi hasil akan muncul setelah rekonsiliasi data dari provider pusat di akhir bulan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
