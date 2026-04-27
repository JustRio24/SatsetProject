@extends('layouts.manager', ['title' => 'Manajemen Tim Area'])

@section('content')
<div class="space-y-8">
    <!-- Korlap List -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800">Daftar Koordinator Lapangan (Korlap)</h3>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">{{ $korlaps->count() }} Orang</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($korlaps as $korlap)
                <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                    <img src="{{ $korlap->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode($korlap->name) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $korlap->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $korlap->phone ?? 'No Phone' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Workers List -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800">Daftar Pekerja / Tenaga Kerja Lapangan</h3>
            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">{{ $workers->count() }} Orang</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Pekerja</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($workers as $worker)
                        <tr>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center font-bold text-gray-500 text-xs">
                                    {{ substr($worker->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ $worker->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $worker->email }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-[10px] font-bold uppercase">Aktif</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
