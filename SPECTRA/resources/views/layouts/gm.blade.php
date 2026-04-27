<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GM Terminal' }} - PT. SatSet MerahPutih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: linear-gradient(180deg, #064e3b 0%, #065f46 100%); }
        .active-link { background: rgba(255, 255, 255, 0.1); border-left: 4px solid #10b981; font-weight: 800; }
        .glass-header { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900" x-data="{ mobileMenu: false }">
    <div class="flex min-h-screen relative">
        <!-- Sidebar -->
        <aside 
            :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'"
            class="w-72 gradient-bg text-white flex flex-col fixed inset-y-0 left-0 z-50 md:relative md:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center border border-white/20">
                            <i class="fas fa-crown text-emerald-400"></i>
                        </div>
                        <div>
                            <h1 class="font-black text-lg leading-none tracking-tighter">SPECTRA</h1>
                            <p class="text-[10px] text-emerald-300 font-bold uppercase tracking-widest">GENERAL MANAGER</p>
                        </div>
                    </div>
                    <button @click="mobileMenu = false" class="md:hidden text-white/50 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 mt-6 px-4 space-y-2">
                <a href="{{ route('gm.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('gm.dashboard') ? 'active-link' : 'text-emerald-100/60 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-th-large w-5"></i>
                    <span class="text-sm font-bold">Papan Skor</span>
                </a>
                <a href="{{ route('gm.monitoring') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('gm.monitoring') ? 'active-link' : 'text-emerald-100/60 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-desktop w-5"></i>
                    <span class="text-sm font-bold">Monitoring Nasional</span>
                </a>
                <a href="{{ route('gm.contracts') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('gm.contracts') ? 'active-link' : 'text-emerald-100/60 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-file-signature w-5"></i>
                    <span class="text-sm font-bold">Manajemen Kontrak</span>
                </a>
                <a href="{{ route('gm.gamification') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('gm.gamification') ? 'active-link' : 'text-emerald-100/60 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-trophy w-5"></i>
                    <span class="text-sm font-bold">KPI & Gamifikasi</span>
                </a>
                <div class="p-6 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-emerald-200 hover:text-white transition-colors w-full font-bold text-sm">
                        <i class="fas fa-power-off w-5"></i>
                        <span>LOGOUT SYSTEM</span>
                    </button>
                </form>
            </div>
            </nav>

            
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="glass-header border-b border-slate-100 p-6 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button @click="mobileMenu = true" class="md:hidden p-2 text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight">{{ $title ?? 'Dashboard' }}</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-emerald-600 font-extrabold uppercase">General Manager</p>
                    </div>
                    <img src="{{ auth()->user()->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="w-10 h-10 rounded-full border-2 border-emerald-500 shadow-sm" alt="Profile">
                </div>
            </header>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-lg shadow-sm font-bold text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Nav (Simple Bottom Bar) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around p-3 z-50">
        <a href="{{ route('gm.dashboard') }}" class="text-gray-400 {{ request()->routeIs('gm.dashboard') ? 'text-emerald-600' : '' }}"><i class="fas fa-th-large text-xl"></i></a>
        <a href="{{ route('gm.monitoring') }}" class="text-gray-400 {{ request()->routeIs('gm.monitoring') ? 'text-emerald-600' : '' }}"><i class="fas fa-camera text-xl"></i></a>
        <a href="{{ route('gm.contracts') }}" class="text-gray-400 {{ request()->routeIs('gm.contracts') ? 'text-emerald-600' : '' }}"><i class="fas fa-file-signature text-xl"></i></a>
        <a href="{{ route('gm.gamification') }}" class="text-gray-400 {{ request()->routeIs('gm.gamification') ? 'text-emerald-600' : '' }}"><i class="fas fa-trophy text-xl"></i></a>
    </div>
</body>
</html>
