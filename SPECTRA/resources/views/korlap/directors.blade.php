@extends('layouts.korlap', ['title' => 'Profil Jajaran Direksi'])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($directors as $director)
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="h-48 overflow-hidden relative">
                <img src="{{ $director->photo }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $director->name }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-6">
                    <h4 class="text-white font-bold text-lg leading-tight">{{ $director->name }}</h4>
                    <p class="text-red-400 text-sm font-semibold uppercase">{{ $director->position }}</p>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm italic leading-relaxed">
                    "{{ $director->bio }}"
                </p>
                <div class="mt-6 pt-6 border-t border-gray-50 flex justify-between items-center">
                    <span class="text-xs text-gray-400">SATSET MerahPutih Indonesia</span>
                    <div class="flex gap-3">
                        <a href="#" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
