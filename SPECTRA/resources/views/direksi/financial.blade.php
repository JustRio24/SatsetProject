@extends('layouts.direksi', ['title' => 'Laporan Keuangan Formal'])

@section('content')
<div class="space-y-8">
    <!-- Filters -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 flex flex-wrap gap-4 items-center">
        <form action="{{ route('direksi.financial') }}" method="GET" class="flex flex-wrap gap-4 items-center w-full">
            <select name="area" class="px-4 py-2 rounded-xl border border-slate-200 text-sm font-bold outline-none focus:ring-2 focus:ring-amber-400">
                <option value="">Semua Wilayah</option>
                @foreach($areas as $area)
                    <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                @endforeach
            </select>
            <select name="line" class="px-4 py-2 rounded-xl border border-slate-200 text-sm font-bold outline-none focus:ring-2 focus:ring-amber-400">
                <option value="">Semua Lini Bisnis</option>
                @foreach($lines as $line)
                    <option value="{{ $line }}" {{ request('line') == $line ? 'selected' : '' }}>{{ $line }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2 bg-slate-900 text-white rounded-xl font-bold text-sm">Terapkan Filter</button>
            <a href="{{ route('direksi.export.pdf') }}" class="px-6 py-2 bg-amber-400 text-slate-900 rounded-xl font-bold text-sm ml-auto flex items-center gap-2 hover:bg-amber-500 transition-all">
                <i class="fas fa-file-pdf"></i> Export Laporan
            </a>
        </form>
    </div>

    <!-- P&L Table -->
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-50 overflow-hidden animate-fade-in-up">
        <div class="p-10 border-b border-slate-50 bg-slate-900 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-xl font-black uppercase tracking-widest">Laporan Laba Rugi Konsolidasi</h3>
                <p class="text-xs text-slate-400 mt-1">Periode: April 2026</p>
            </div>
            <div class="text-left md:text-right">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Mata Uang</p>
                <p class="text-sm font-black text-amber-400 uppercase">IDR (Rupiah)</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <div class="p-10 min-w-[600px]">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-slate-100">
                        <!-- Revenue Section -->
                        <tr>
                            <td colspan="2" class="py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">PENDAPATAN</td>
                        </tr>
                        <tr>
                            <td class="py-4 pl-4 font-bold text-slate-700">Total Penjualan / Kontrak Proyek</td>
                            <td class="py-4 text-right font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td class="py-4 pl-4 font-black text-slate-900">JUMLAH PENDAPATAN KOTOR</td>
                            <td class="py-4 text-right font-black text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>

                        <!-- COGS / Expenses Section -->
                        <tr>
                            <td colspan="2" class="py-8 font-black text-slate-400 uppercase tracking-widest text-[10px]">PENGELUARAN & BEBAN</td>
                        </tr>
                        <tr>
                            <td class="py-4 pl-4 font-bold text-slate-700">Beban Gaji & Upah Pekerja</td>
                            <td class="py-4 text-right font-bold text-rose-500">(Rp {{ number_format($salaries, 0, ',', '.') }})</td>
                        </tr>
                        <tr>
                            <td class="py-4 pl-4 font-bold text-slate-700">Beban Operasional Lapangan (Estimasi 10%)</td>
                            <td class="py-4 text-right font-bold text-rose-500">(Rp {{ number_format($operational, 0, ',', '.') }})</td>
                        </tr>
                        <tr>
                            <td class="py-4 pl-4 font-bold text-slate-700">Beban Pajak (PPN 11%)</td>
                            <td class="py-4 text-right font-bold text-rose-500">(Rp {{ number_format($tax, 0, ',', '.') }})</td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td class="py-4 pl-4 font-black text-slate-900">TOTAL BEBAN</td>
                            <td class="py-4 text-right font-black text-rose-600">(Rp {{ number_format($salaries + $operational + $tax, 0, ',', '.') }})</td>
                        </tr>

                        <!-- Net Income -->
                        <tr class="bg-amber-400">
                            <td class="py-6 pl-4 font-black text-slate-900 text-lg uppercase tracking-widest">LABA BERSIH (NET PROFIT)</td>
                            <td class="py-6 pr-4 text-right font-black text-slate-900 text-2xl">Rp {{ number_format($totalRevenue - ($salaries + $operational + $tax), 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
