@extends('layouts.finance', ['title' => 'Pencatatan Biaya Operasional'])

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
    <!-- Left: Form -->
    <div class="xl:col-span-1">
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-50 overflow-hidden sticky top-32">
            <div class="p-8 bg-indigo-900 text-white">
                <h3 class="font-black uppercase tracking-widest text-sm">Input Biaya Baru</h3>
                <p class="text-indigo-300 text-[10px] mt-1">Catat setiap pengeluaran operasional proyek.</p>
            </div>
            <form action="{{ route('finance.expenses.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Proyek</label>
                    <select name="project_id" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-sm">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori Biaya</label>
                    <select name="category" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-sm">
                        <option value="Bahan Proyek">Bahan Proyek (Cat, Semen, dll)</option>
                        <option value="Bensin & Transport">Bensin & Transport</option>
                        <option value="Konsumsi Lapangan">Konsumsi Lapangan</option>
                        <option value="Alat Kerja">Alat Kerja</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah (Rp)</label>
                    <input type="number" name="amount" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none font-black text-sm" placeholder="0">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Keterangan</label>
                    <textarea name="description" rows="3" class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none font-medium text-sm" placeholder="Detail pengeluaran..."></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-900 text-white font-black py-5 rounded-[1.5rem] shadow-xl hover:bg-black transition-all transform active:scale-95 uppercase tracking-widest text-xs">
                    Simpan Pengeluaran
                </button>
            </form>
        </div>
    </div>

    <!-- Right: List -->
    <div class="xl:col-span-2">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="font-black text-slate-800 uppercase tracking-widest text-sm">Riwayat Pengeluaran Operasional</h3>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Proyek</th>
                            <th class="px-8 py-5">Kategori / Ket.</th>
                            <th class="px-8 py-5">Tanggal</th>
                            <th class="px-8 py-5 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($expenses as $expense)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-6 text-sm font-black text-slate-800">{{ $expense->project_name }}</td>
                                <td class="px-8 py-6">
                                    <p class="text-[10px] font-black text-indigo-600 uppercase">{{ $expense->category }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $expense->description }}</p>
                                </td>
                                <td class="px-8 py-6 text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                <td class="px-8 py-6 text-right text-sm font-black text-rose-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
