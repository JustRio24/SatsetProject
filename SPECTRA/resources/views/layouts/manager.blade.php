<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Manager Terminal' }} - PT. SatSet MerahPutih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); }
        .active-link { background: rgba(255, 255, 255, 0.1); border-left: 4px solid #3b82f6; font-weight: 800; }
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
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black text-xl shadow-lg shadow-blue-500/20">S</div>
                        <div>
                            <h1 class="font-black text-lg leading-none tracking-tighter">SATSET</h1>
                            <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">MANAGER AREA</p>
                        </div>
                    </div>
                    <button @click="mobileMenu = false" class="md:hidden text-white/50 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 mt-6 px-4 space-y-2">
                <a href="{{ route('manager.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('manager.dashboard') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="text-sm font-bold">Dashboard</span>
                </a>
                <a href="{{ route('manager.projects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('manager.projects.*') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-briefcase w-5"></i>
                    <span class="text-sm font-bold">Proyek & Closing</span>
                </a>
                <a href="{{ route('manager.team') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('manager.team') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="text-sm font-bold">Manajemen Tim</span>
                </a>
                <a href="{{ route('manager.monitoring') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('manager.monitoring') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-eye w-5"></i>
                    <span class="text-sm font-bold">Monitoring Lapangan</span>
                </a>
                <a href="{{ route('manager.salary-recap') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('manager.salary-recap') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-calculator w-5"></i>
                    <span class="text-sm font-bold">Rekap Gaji & Hasil</span>
                </a>
                <a href="{{ route('manager.monthly-report') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('manager.monthly-report') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-file-invoice-dollar w-5"></i>
                    <span class="text-sm font-bold">Laporan Bulanan</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-gray-400 hover:text-white transition-colors w-full">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
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
                    <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase">
                        {{ auth()->user()->area }}
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 uppercase">Manager Area</p>
                    </div>
                    <img src="{{ auth()->user()->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" class="w-10 h-10 rounded-full border-2 border-blue-500 shadow-sm" alt="Profile">
                </div>
            </header>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
