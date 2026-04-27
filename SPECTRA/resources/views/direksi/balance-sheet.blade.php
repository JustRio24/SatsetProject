@extends('layouts.direksi', ['title' => 'Laporan Neraca Perusahaan'])

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-50 overflow-hidden">
        <div class="p-12 bg-slate-900 text-white flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-black uppercase tracking-tighter">Neraca Konsolidasi</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">PT. SatSet MerahPutih Indonesia</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-black text-amber-400">2026</p>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Fiscal Year</p>
            </div>
        </div>

        <div class="p-12 space-y-12">
            <!-- Assets Section -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-8 bg-amber-400 rounded-full"></div>
                    <h4 class="text-lg font-black text-slate-800 uppercase tracking-widest">ASET (AKTIVA)</h4>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-4 border-b border-slate-50">
                        <span class="text-sm font-bold text-slate-500">Kas & Setara Kas</span>
                        <span class="text-lg font-black text-slate-900">Rp {{ number_format($cash, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-slate-50">
                        <div>
                            <span class="text-sm font-bold text-slate-500">Piutang Klien</span>
                            <p class="text-[10px] text-amber-600 font-bold uppercase mt-1">Pending Invoices</p>
                        </div>
                        <span class="text-lg font-black text-slate-900">Rp {{ number_format($receivables, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-6 bg-slate-50 px-6 rounded-2xl">
                        <span class="text-sm font-black text-slate-800 uppercase tracking-widest">TOTAL ASET</span>
                        <span class="text-xl font-black text-slate-900">Rp {{ number_format($cash + $receivables, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Liabilities Section -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-8 bg-rose-500 rounded-full"></div>
                    <h4 class="text-lg font-black text-slate-800 uppercase tracking-widest">KEWAJIBAN & MODAL (PASIVA)</h4>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-4 border-b border-slate-50">
                        <div>
                            <span class="text-sm font-bold text-slate-500">Hutang Gaji & Upah</span>
                            <p class="text-[10px] text-rose-500 font-bold uppercase mt-1">Unrealized Payouts</p>
                        </div>
                        <span class="text-lg font-black text-rose-600">Rp {{ number_format($payables, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-slate-50">
                        <span class="text-sm font-bold text-slate-500">Modal Saham & Laba Ditahan</span>
                        <span class="text-lg font-black text-slate-900">Rp {{ number_format($cash + $receivables - $payables, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-6 bg-slate-50 px-6 rounded-2xl">
                        <span class="text-sm font-black text-slate-800 uppercase tracking-widest">TOTAL PASIVA</span>
                        <span class="text-xl font-black text-slate-900">Rp {{ number_format($cash + $receivables, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-12 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <i class="fas fa-circle-check text-emerald-500"></i>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Balance Verified by Finance Terminal</p>
            </div>
            <button class="px-8 py-3 bg-amber-400 text-slate-900 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-amber-500/20">
                Generate Digital Sign
            </button>
        </div>
    </div>
</div>
@endsection
