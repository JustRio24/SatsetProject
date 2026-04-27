@extends('layouts.korlap', ['title' => 'Gaji & Hasil Bagi'])

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <p class="text-gray-400 text-sm font-medium uppercase tracking-wider mb-1">Total Saldo Masuk</p>
            <h3 class="text-4xl font-bold">Rp {{ number_format($salaries->sum('amount'), 0, ',', '.') }}</h3>
            <p class="text-green-400 text-sm mt-2 font-medium"><i class="fas fa-check-circle mr-1"></i> Data Terverifikasi oleh Sistem</p>
        </div>
        <div class="w-full md:w-auto">
            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-2xl transition-all shadow-lg shadow-red-900/20">
                Hubungi Admin Gaji
            </button>
        </div>
    </div>

    <!-- Salary List -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Riwayat Pembayaran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($salaries as $salary)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $salary->type === 'gaji' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                    {{ strtoupper($salary->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="flex items-center gap-1.5 text-sm text-green-600 font-semibold">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    {{ strtoupper($salary->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-lg font-bold text-gray-900">Rp {{ number_format($salary->amount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <i class="fas fa-receipt text-4xl mb-3 text-gray-200"></i>
                                <p>Belum ada data pembayaran untuk akun Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
