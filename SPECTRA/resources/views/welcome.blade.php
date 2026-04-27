<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. SatSet MerahPutih Indonesia - Solusi Tenaga Kerja & Hiburan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .gradient-text { background: linear-gradient(135deg, #ef4444 0%, #1e293b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-bg { background: radial-gradient(circle at top right, #fee2e2 0%, #f8fafc 40%); }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto glass rounded-3xl px-8 py-4 flex justify-between items-center shadow-xl shadow-slate-200/50">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-500/20">
                    <i class="fas fa-bolt"></i>
                </div>
                <span class="font-black text-xl tracking-tighter uppercase">SatSet<span class="text-red-600">Group</span></span>
            </div>
            
            <div class="hidden md:flex items-center gap-10 font-bold text-sm text-slate-600">
                <a href="#services" class="hover:text-red-600 transition-colors">Layanan</a>
                <a href="#about" class="hover:text-red-600 transition-colors">Tentang Kami</a>
                <a href="#contact" class="hover:text-red-600 transition-colors">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-red-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-500/20">Login System</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="pt-40 pb-20 px-6 hero-bg overflow-hidden relative">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="space-y-8 relative z-10">
                <span class="px-4 py-2 bg-red-100 text-red-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-sm">Digitalizing Labor Services</span>
                <h1 class="text-6xl md:text-7xl font-black text-slate-900 tracking-tighter leading-none">
                    Membangun Masa Depan Dengan <span class="gradient-text">Kecepatan & Kualitas.</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-xl">
                    PT. SatSet MerahPutih Indonesia adalah mitra strategis Anda dalam penyediaan tenaga kerja profesional, layanan bengkel terpadu, dan solusi hiburan digital terkini.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="px-10 py-5 bg-red-600 text-white rounded-3xl font-black text-sm uppercase tracking-widest hover:bg-red-700 transition-all shadow-2xl shadow-red-500/30 group">
                        Mulai Sekarang <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </a>
                    <a href="#services" class="px-10 py-5 bg-white text-slate-900 rounded-3xl font-black text-sm uppercase tracking-widest border border-slate-200 hover:bg-slate-50 transition-all shadow-lg">Layanan Kami</a>
                </div>
            </div>
            
            <div class="relative">
                <div class="w-full aspect-square bg-gradient-to-tr from-red-100 to-amber-50 rounded-[4rem] rotate-3 absolute -inset-4"></div>
                <div class="relative rounded-[4rem] overflow-hidden shadow-2xl border-8 border-white group">
                    <img src="{{ asset('images/hero.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="Satset Work">
                    <div class="absolute inset-0 bg-gradient-to-t from-red-900/40 to-transparent"></div>
                    <div class="absolute bottom-10 left-10 text-white">
                        <p class="text-4xl font-black">2.5k+</p>
                        <p class="text-sm font-bold opacity-80 uppercase tracking-widest">Pekerja Profesional</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Services -->
    <section id="services" class="py-32 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center space-y-4 mb-20">
                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tighter italic">Layanan Unggulan Kami</h2>
                <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Empowering 3 major business lines across Indonesia</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Construction -->
                <div class="p-10 rounded-[3rem] bg-[#f8fafc] border border-slate-50 hover:bg-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:bg-red-600 group-hover:text-white transition-all">
                        <i class="fas fa-trowel-bricks"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-4 uppercase">Tenaga Kerja & Bangunan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">Penyediaan kuli, tukang bangunan, dan mandor profesional untuk segala jenis proyek konstruksi nasional.</p>
                    <ul class="space-y-3 text-xs font-bold text-slate-600 uppercase">
                        <li><i class="fas fa-check text-red-600 mr-2"></i> Konstruksi Sipil</li>
                        <li><i class="fas fa-check text-red-600 mr-2"></i> Renovasi Hunian</li>
                        <li><i class="fas fa-check text-red-600 mr-2"></i> Manajemen Mandor</li>
                    </ul>
                </div>

                <!-- Workshop -->
                <div class="p-10 rounded-[3rem] bg-[#f8fafc] border border-slate-50 hover:bg-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-gears"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-4 uppercase">Bengkel Terpadu</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">Layanan perawatan kendaraan dan mesin industri dengan tim teknisi ahli yang berpengalaman.</p>
                    <ul class="space-y-3 text-xs font-bold text-slate-600 uppercase">
                        <li><i class="fas fa-check text-blue-600 mr-2"></i> Perawatan Rutin</li>
                        <li><i class="fas fa-check text-blue-600 mr-2"></i> Perbaikan Mesin</li>
                        <li><i class="fas fa-check text-blue-600 mr-2"></i> Spare Part Original</li>
                    </ul>
                </div>

                <!-- Entertainment -->
                <div class="p-10 rounded-[3rem] bg-[#f8fafc] border border-slate-50 hover:bg-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <i class="fas fa-tv"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-4 uppercase">Entertainment & Tech</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">Instalasi jaringan TV, internet, dan pengelolaan konten hiburan untuk perumahan dan apartemen.</p>
                    <ul class="space-y-3 text-xs font-bold text-slate-600 uppercase">
                        <li><i class="fas fa-check text-emerald-600 mr-2"></i> Instalasi Jaringan</li>
                        <li><i class="fas fa-check text-emerald-600 mr-2"></i> Smart Home System</li>
                        <li><i class="fas fa-check text-emerald-600 mr-2"></i> Support 24/7</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto bg-slate-900 rounded-[3.5rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tighter">Siap Untuk Meningkatkan <br> Performa Bisnis Anda?</h2>
                <p class="text-slate-400 font-medium max-w-xl mx-auto">Gabung bersama ribuan mitra lainnya yang telah merasakan kemudahan manajemen operasional dengan ekosistem SatSetGroup.</p>
                <div class="pt-4">
                    <a href="{{ route('login') }}" class="px-12 py-5 bg-white text-slate-900 rounded-3xl font-black text-sm uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-xl shadow-white/5">Akses Dashboard SPECTRA</a>
                </div>
            </div>
            <i class="fas fa-rocket absolute -bottom-10 -right-10 text-[200px] text-white/5"></i>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 border-t border-slate-100 bg-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center text-white text-xs">
                    <i class="fas fa-bolt"></i>
                </div>
                <span class="font-black text-sm uppercase tracking-tighter">SatSet<span class="text-red-600">Group</span></span>
            </div>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">© 2026 PT. SatSet MerahPutih Indonesia. All Rights Reserved.</p>
            <div class="flex items-center gap-6 text-slate-400">
                <a href="#" class="hover:text-red-600 transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-red-600 transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                <a href="#" class="hover:text-red-600 transition-colors"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>
