<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPECTRA Terminal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .login-bg { 
            background: radial-gradient(circle at 0% 0%, #fee2e2 0%, #f8fafc 50%),
                        radial-gradient(circle at 100% 100%, #e0f2fe 0%, #f8fafc 50%);
        }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border: 1px solid white; }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-6">
    <div class="max-w-5xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left: Branding -->
        <div class="hidden lg:block space-y-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-red-600 rounded-3xl flex items-center justify-center text-white text-2xl shadow-2xl shadow-red-500/30">
                    <i class="fas fa-bolt"></i>
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase">SPECTRA<br><span class="text-red-600">Terminal</span></h1>
            </div>
            <h2 class="text-5xl font-black text-slate-800 tracking-tighter leading-tight">
                Integrasi Operasional <br> <span class="text-slate-400 italic">Tanpa Batas.</span>
            </h2>
            <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-sm">
                Akses dashboard manajemen operasional PT. SatSet MerahPutih Indonesia melalui terminal terenkripsi.
            </p>
            
            <div class="pt-8 flex gap-6">
                <div class="text-center">
                    <p class="text-3xl font-black text-slate-900 leading-none">5</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Level Akses</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-slate-900 leading-none">100%</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Akurasi Data</p>
                </div>
            </div>
        </div>

        <!-- Right: Login Form -->
        <div class="glass-card rounded-[3.5rem] p-10 md:p-14 shadow-2xl shadow-slate-300/50">
            <div class="mb-10 text-center lg:text-left">
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic mb-2">Secure Login</h3>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Silakan masukkan kredensial Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Email Address</label>
                    <div class="relative group">
                        <i class="fas fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-red-500 transition-colors"></i>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                            class="w-full pl-14 pr-6 py-5 bg-white rounded-2xl border border-slate-100 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none font-bold text-sm transition-all shadow-sm">
                    </div>
                    @if($errors->has('email'))
                        <p class="text-[10px] text-red-500 font-bold uppercase ml-4">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-4">
                        <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Access Key</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Forgot?</a>
                        @endif
                    </div>
                    <div class="relative group">
                        <i class="fas fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-red-500 transition-colors"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="w-full pl-14 pr-6 py-5 bg-white rounded-2xl border border-slate-100 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none font-bold text-sm transition-all shadow-sm">
                    </div>
                    @if($errors->has('password'))
                        <p class="text-[10px] text-red-500 font-bold uppercase ml-4">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="flex items-center ml-4">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded text-red-600 focus:ring-red-500 border-slate-200">
                    <label for="remember_me" class="ml-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ingat akun ini</label>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-red-500/20 hover:bg-red-700 hover:-translate-y-1 transition-all active:scale-95">
                        Authorize Access <i class="fas fa-shield-halved ml-2"></i>
                    </button>
                </div>

                <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-8">
                    Masalah login? Hubungi IT Support PT. SatSet
                </p>
            </form>
        </div>
    </div>
</body>
</html>
