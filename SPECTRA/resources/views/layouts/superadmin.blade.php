<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Super Admin' }} - SPECTRA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-header { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .active-link { background: linear-gradient(to right, rgba(99, 102, 241, 0.1), transparent); color: #4f46e5; border-left: 4px solid #4f46e5; }
        .active-link i { color: #4f46e5; }
        
        /* Premium Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
    </style>
</head>
<body class="text-slate-600 h-screen overflow-hidden" x-data="{ mobileMenu: false }">

    <div class="flex h-full">
        <!-- Overlay -->
        <div x-show="mobileMenu" @click="mobileMenu = false" class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden backdrop-blur-sm transition-opacity" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static inset-y-0 left-0 w-[280px] bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out z-50 flex flex-col shadow-2xl lg:translate-x-0">
            <div class="p-8 border-b border-white/5">
                <div class="flex items-center justify-between lg:justify-center">
                    <div>
                        <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">SPECTRA</h1>
                        <p class="text-[9px] font-bold text-indigo-400 tracking-widest uppercase mt-1">Super Admin Panel</p>
                    </div>
                    <button @click="mobileMenu = false" class="lg:hidden text-slate-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
                <p class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4 mt-2">Core System</p>
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('superadmin.dashboard') ? 'active-link' : 'hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-satellite-dish w-5 text-center text-lg"></i>
                    <span class="font-bold text-sm">System Overview</span>
                </a>
                <a href="{{ route('superadmin.users') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('superadmin.users*') ? 'active-link' : 'hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-users-gear w-5 text-center text-lg"></i>
                    <span class="font-bold text-sm">User Management</span>
                </a>
                
                <div class="p-8 border-t border-white/5 mt-8">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-4 text-slate-400 hover:text-white transition-all w-full font-bold text-sm">
                        <i class="fas fa-power-off w-5 text-center"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-[#f8fafc]">
            <header class="glass-header border-b border-slate-200 p-6 lg:px-12 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="mobileMenu = true" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>
                    <h2 class="text-xl lg:text-2xl font-black text-slate-800 tracking-tight">{{ $title ?? 'Control Panel' }}</h2>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-slate-900 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-indigo-600 font-black uppercase tracking-widest mt-1">Super Admin</p>
                    </div>
                    <div class="relative">
                        <img src="{{ auth()->user()->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=4f46e5&color=fff' }}" class="w-12 h-12 rounded-2xl border-2 border-indigo-400 shadow-xl" alt="Profile">
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
                @if(session('error'))
                    <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-2xl shadow-sm font-bold text-sm flex items-center gap-3">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Nav (Simple Bottom Bar) -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around p-3 z-50 shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <a href="{{ route('superadmin.dashboard') }}" class="text-slate-400 {{ request()->routeIs('superadmin.dashboard') ? 'text-indigo-600' : '' }}"><i class="fas fa-satellite-dish text-xl"></i></a>
        <a href="{{ route('superadmin.users') }}" class="text-slate-400 {{ request()->routeIs('superadmin.users*') ? 'text-indigo-600' : '' }}"><i class="fas fa-users-gear text-xl"></i></a>
    </div>
</body>
</html>
