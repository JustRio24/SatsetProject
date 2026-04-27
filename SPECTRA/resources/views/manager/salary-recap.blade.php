@extends('layouts.manager', ['title' => 'Rekap Gaji & Bagi Hasil'])

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-bold text-xl text-gray-800">Skema Bagi Hasil (5:3:1:1)</h3>
            <p class="text-sm text-gray-500">Kalkulasi otomatis berdasarkan nilai kontrak proyek aktif.</p>
        </div>
        <button class="bg-green-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg hover:bg-green-700 transition-all flex items-center gap-2">
            <i class="fas fa-check-double"></i> Approve Semua Rekap
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Proyek</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Pekerja (5)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">PT (3)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Korlap (1)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Manager Area (1)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recaps as $recap)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-800">{{ $recap['project_name'] }}</p>
                                <p class="text-xs text-gray-400">Nilai: Rp {{ number_format($recap['total'], 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-700">Rp {{ number_format($recap['worker_share'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-700">Rp {{ number_format($recap['company_share'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-blue-600">Rp {{ number_format($recap['korlap_share'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-green-600">Rp {{ number_format($recap['manager_share'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right">
                                <button class="px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-lg uppercase shadow-sm">Approve</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-900 text-white">
                    <tr>
                        <td class="px-6 py-4 font-bold">TOTAL AREA</td>
                        <td class="px-6 py-4 font-bold">Rp {{ number_format(collect($recaps)->sum('worker_share'), 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold">Rp {{ number_format(collect($recaps)->sum('company_share'), 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold">Rp {{ number_format(collect($recaps)->sum('korlap_share'), 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-green-400">Rp {{ number_format(collect($recaps)->sum('manager_share'), 0, ',', '.') }}</td>
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
