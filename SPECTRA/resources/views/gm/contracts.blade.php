@extends('layouts.gm', ['title' => 'Manajemen Kontrak Strategis'])

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-emerald-50/30">
            <div>
                <h3 class="font-extrabold text-gray-800 text-lg uppercase tracking-wider">Arsip Kontrak Lini Bisnis</h3>
                <p class="text-sm text-gray-500">Daftar dokumen legalitas dan nilai proyek nasional.</p>
            </div>
            <i class="fas fa-file-contract text-emerald-200 text-4xl"></i>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-[10px] font-extrabold uppercase tracking-widest">
                        <th class="px-8 py-5">Proyek & Klien</th>
                        <th class="px-8 py-5">Area</th>
                        <th class="px-8 py-5">Nilai Kontrak</th>
                        <th class="px-8 py-5">Status Dokumen</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($projects as $project)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <p class="text-sm font-extrabold text-gray-800">{{ $project->name }}</p>
                                <p class="text-xs text-emerald-600 font-bold">{{ $project->client_name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-extrabold text-gray-600 uppercase">{{ $project->area }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-extrabold text-gray-800">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @if($project->contract_file)
                                    <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-extrabold uppercase">
                                        <i class="fas fa-check-circle"></i> Terunggah
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 text-red-400 text-xs font-extrabold uppercase">
                                        <i class="fas fa-times-circle"></i> Belum Ada
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button onclick="openUploadModal({{ $project->id }}, '{{ $project->name }}')" class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-bold rounded-xl uppercase hover:bg-emerald-700 transition-all shadow-md">
                                    Upload Kontrak
                                </button>
                                @if($project->contract_file)
                                    <a href="{{ asset('storage/' . $project->contract_file) }}" target="_blank" class="ml-2 px-4 py-2 bg-slate-800 text-white text-[10px] font-bold rounded-xl uppercase hover:bg-slate-900 transition-all">
                                        View
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Simple Modal for Upload -->
<div id="uploadModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-in zoom-in duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-emerald-600 text-white">
            <h3 class="font-extrabold text-lg uppercase tracking-wider">Upload Kontrak PDF</h3>
            <button onclick="closeUploadModal()" class="text-white hover:rotate-90 transition-transform"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('gm.contracts.upload') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            <input type="hidden" name="project_id" id="modal_project_id">
            <p class="text-xs text-gray-400 font-bold uppercase mb-4 tracking-widest" id="modal_project_name"></p>
            
            <div class="border-2 border-dashed border-gray-100 rounded-3xl p-10 text-center group hover:border-emerald-500 transition-all cursor-pointer relative">
                <input type="file" name="contract_file" required class="absolute inset-0 opacity-0 cursor-pointer">
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-200 mb-3 group-hover:text-emerald-500 transition-colors"></i>
                <p class="text-xs font-bold text-gray-400 group-hover:text-emerald-700 transition-colors">Klik atau seret file PDF di sini</p>
                <p class="text-[10px] text-gray-400 mt-1">Maksimal 5MB</p>
            </div>

            <button type="submit" class="w-full mt-8 bg-emerald-600 text-white font-extrabold py-4 rounded-2xl shadow-xl hover:bg-emerald-700 transition-all transform active:scale-95 uppercase tracking-widest text-xs">
                Simpan Dokumen Kontrak
            </button>
        </form>
    </div>
</div>

<script>
    function openUploadModal(id, name) {
        document.getElementById('modal_project_id').value = id;
        document.getElementById('modal_project_name').innerText = name;
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }
    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
    }
</script>
@endsection
