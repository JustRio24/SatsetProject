<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Board of Directors' }} - PT. SatSet MerahPutih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .royal-bg { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); }
        .active-link { background: rgba(251, 191, 36, 0.1); border-left: 4px solid #fbbf24; color: #fbbf24; font-weight: 800; }
        .glass-header { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900" x-data="{ mobileMenu: false }">
    <div class="flex min-h-screen relative">
        <!-- Sidebar -->
        <aside 
            :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'"
            class="w-80 royal-bg text-white flex flex-col fixed inset-y-0 left-0 z-50 lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-tr from-amber-500 to-yellow-300 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <i class="fas fa-building-columns text-slate-900 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="font-black text-xl leading-none tracking-tighter">SATSET</h1>
                            <p class="text-[10px] text-amber-400 font-bold uppercase tracking-widest">BOARD OF DIRECTORS</p>
                        </div>
                    </div>
                    <button @click="mobileMenu = false" class="lg:hidden text-white/50 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 mt-8 px-6 space-y-3">
                <a href="{{ route('direksi.dashboard') }}" class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ request()->routeIs('direksi.dashboard') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-chart-pie w-5"></i>
                    <span class="font-bold text-sm">Dashboard Utama</span>
                </a>
                <a href="{{ route('direksi.financial') }}" class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ request()->routeIs('direksi.financial') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-file-invoice-dollar w-5"></i>
                    <span class="font-bold text-sm">Laba Rugi</span>
                </a>
                @if(auth()->user()->position === 'Direktur Utama' || auth()->user()->position === 'Dirut')
                <a href="{{ route('direksi.balance-sheet') }}" class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ request()->routeIs('direksi.balance-sheet') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-scale-balanced w-5"></i>
                    <span class="font-bold text-sm">Neraca (Dirut Only)</span>
                </a>
                @endif
                <a href="{{ route('direksi.sdm-legal') }}" class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ request()->routeIs('direksi.sdm-legal') ? 'active-link' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-gavel w-5"></i>
                    <span class="font-bold text-sm">SDM & Legalitas</span>
                </a>
            </nav>

            <div class="p-8 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-4 text-slate-400 hover:text-white transition-all w-full font-bold text-sm">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>EXIT TERMINAL</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="glass-header border-b border-slate-100 p-6 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button @click="mobileMenu = true" class="lg:hidden p-2 text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $title ?? 'Executive Intelligence' }}</h2>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-slate-900 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-amber-600 font-black uppercase tracking-widest mt-1">{{ auth()->user()->position }}</p>
                    </div>
                    <div class="relative">
                        <img src="{{ auth()->user()->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=fbbf24&color=0f172a' }}" class="w-12 h-12 rounded-2xl border-2 border-amber-400 shadow-xl" alt="Profile">
                        <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                </div>
            </header>

            <div class="p-8 lg:p-12">
                @if(session('success'))
                    <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-2xl shadow-sm font-bold text-sm flex items-center gap-3">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
