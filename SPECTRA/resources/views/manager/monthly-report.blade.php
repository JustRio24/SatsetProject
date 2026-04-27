@extends('layouts.manager', ['title' => 'Laporan Bulanan Area'])

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <h3 class="font-bold text-2xl text-gray-800">Laporan Keuangan Area</h3>
            <p class="text-gray-500">Ringkasan performa untuk wilayah {{ auth()->user()->area }} - {{ $month }}</p>
        </div>
        <button class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Download PDF
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Revenue Card -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Total Pendapatan (Gross)</p>
                <h4 class="text-3xl font-extrabold text-blue-600">Rp {{ number_format($revenue, 0, ',', '.') }}</h4>
            </div>
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>

        <!-- Expense Card -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Estimasi Pengeluaran</p>
                <h4 class="text-3xl font-extrabold text-red-500">Rp {{ number_format($expenses, 0, ',', '.') }}</h4>
            </div>
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </div>

    <!-- Profit Analysis -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 text-white">
        <h3 class="font-bold text-xl mb-6">Analisis Profitabilitas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10">
                <p class="text-gray-400 text-xs font-bold uppercase mb-2">Profit Bersih (Estimasi)</p>
                <p class="text-2xl font-bold text-green-400">Rp {{ number_format($revenue - $expenses, 0, ',', '.') }}</p>
            </div>
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10">
                <p class="text-gray-400 text-xs font-bold uppercase mb-2">Profit Margin</p>
                <p class="text-2xl font-bold">40%</p>
            </div>
            <div class="p-6 bg-white/5 rounded-2xl border border-white/10">
                <p class="text-gray-400 text-xs font-bold uppercase mb-2">Pertumbuhan (MoM)</p>
                <p class="text-2xl font-bold text-blue-400">+12.5%</p>
            </div>
        </div>
    </div>

    <!-- Breakdown Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Detail Transaksi Bulan Ini</h3>
        </div>
        <table class="w-full text-left">
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">Total Nilai Kontrak Baru</td>
                    <td class="px-6 py-4 text-sm font-bold text-right text-blue-600">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">Estimasi Alokasi Gaji Pekerja (50%)</td>
                    <td class="px-6 py-4 text-sm font-bold text-right text-red-400">- Rp {{ number_format($revenue * 0.5, 0, ',', '.') }}</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">Biaya Operasional Lapangan</td>
                    <td class="px-6 py-4 text-sm font-bold text-right text-red-400">- Rp {{ number_format($revenue * 0.1, 0, ',', '.') }}</td>
                </tr>
                <tr class="bg-blue-50/50">
                    <td class="px-6 py-4 text-sm font-bold text-blue-800">Sisa Anggaran Perusahaan & Fee</td>
                    <td class="px-6 py-4 text-sm font-extrabold text-right text-blue-800">Rp {{ number_format($revenue - $expenses, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
