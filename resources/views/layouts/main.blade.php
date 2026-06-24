<!DOCTYPE html>
<html lang="id" class="scroll-smooth"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'Ni Laundry')</title>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">

    <style> 
        [x-cloak] { display: none !important; }
        .footer-texture {
            background-image: url("{{ asset('img/cubes.png') }}");
        }
        /* Mencegah scroll horizontal di level root */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
            width: 100%;
            margin: 0;
            padding: 0;
        }
    </style>

    <meta name="description" content="Jasa laundry kiloan dan satuan terbaik dengan teknologi modern.">
    <meta name="theme-color" content="#0f172a">
    <link rel="icon" href="{{ asset('img/logo.webp') }}" type="image/webp">
</head>

<body class="text-slate-600 antialiased font-sans flex flex-col min-h-screen w-full relative selection:bg-brand-500 selection:text-white">

    {{-- PRELOADER --}}
    <div id="preloader" role="status" class="fixed inset-0 z-[9999] bg-slate-900 flex flex-col items-center justify-center">
        <div class="flex items-center gap-3 animate-pulse">
            <span class="text-3xl md:text-5xl font-bold tracking-tight text-white">
                Ni Laundry<span class="text-fresh-500">.</span>
            </span>
        </div>
        <div class="mt-6 w-40 md:w-64 h-1 bg-slate-800 rounded-full overflow-hidden">
            <div id="loader-bar" class="h-full bg-brand-500 w-0"></div>
        </div>
    </div>

    <script>
        if (sessionStorage.getItem('introShown')) {
            document.getElementById('preloader').style.display = 'none';
        }
    </script>

    {{-- NAVBAR --}}
    <nav x-data="{ scrolled: false, mobileOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         class="fixed top-0 w-full z-50 transition-all duration-300 left-0 right-0"
         :class="scrolled ? 'py-2' : 'py-3 md:py-6'">
        
        {{-- Container Navbar: Menggunakan px-4 secara konsisten --}}
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="rounded-2xl transition-all duration-300 border border-transparent"
                 :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm border-white/40 pl-4 pr-3 py-2' : 'bg-transparent'">
            
                <div class="flex justify-between items-center">
                    {{-- Logo Area --}}
                    <a href="/" class="flex items-center gap-2 md:gap-3 group shrink-0">
                        <img src="{{ asset('img/logo.webp') }}" 
                             alt="Logo Ni Laundry" 
                             width="40" height="40" 
                             class="h-8 w-8 md:h-10 md:w-10 object-contain">
                        <span class="text-lg md:text-2xl font-bold text-slate-800 tracking-tight transition-colors"
                              :class="scrolled ? 'text-slate-800' : 'text-slate-900'">
                            Ni Laundry<span class="text-fresh-500">.</span>
                        </span>
                    </a>

                    {{-- Desktop Menu --}}
                    <div class="hidden md:flex items-center gap-1 bg-white/60 p-1.5 rounded-full border border-white/50 backdrop-blur-sm shadow-sm">
                        @if(Auth::guard('admin')->check())
                            <a href="/admin/dashboard" class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ Request::is('admin/dashboard') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Dashboard</a>
                            <a href="/admin/pesanan" class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ Request::is('admin/pesanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Pesanan</a>
                            <a href="/admin/layanan" class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ Request::is('admin/layanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Layanan</a>
                            <a href="/admin/diskon" class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ Request::is('admin/diskon') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Diskon</a>
                            <a href="/admin/users" class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ Request::is('admin/users') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Admin</a>
                        @else 
                            <a href="/" class="px-5 py-2 rounded-full text-sm font-semibold transition-all {{ Request::is('/') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Beranda</a> 
                            <a href="/layanan" class="px-5 py-2 rounded-full text-sm font-semibold transition-all {{ Request::is('layanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Layanan</a>
                            @auth
                            <a href="/riwayat" class="px-5 py-2 rounded-full text-sm font-semibold transition-all {{ Request::is('riwayat') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Riwayat</a>
                            @endauth
                        @endif
                    </div>

                    {{-- Desktop Right (Login/Logout) --}}
                    <div class="hidden md:flex items-center gap-4">
                        @if(Auth::check() || Auth::guard('admin')->check())
                            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                    class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center hover:bg-red-50 text-slate-600 hover:text-red-500 transition-all shadow-sm">
                                <i class="ph-bold ph-sign-out text-xl"></i>
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        @else
                            <a href="/login" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-brand-600 transition-all shadow-lg hover:shadow-brand-500/20">
                                Login
                            </a>
                        @endif
                    </div>

                    {{-- Mobile Toggle Button --}}
                    <button @click="mobileOpen = !mobileOpen" aria-label="Toggle Menu" class="md:hidden p-2 text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="ph-bold text-2xl" :class="mobileOpen ? 'ph-x' : 'ph-list'"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div x-show="mobileOpen" x-collapse x-cloak class="md:hidden absolute top-full left-0 w-full px-4 mt-2">
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-white/50 p-2 flex flex-col gap-1 ring-1 ring-black/5">
                <a href="/" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                    Beranda <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                </a>
                <a href="/layanan" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                    Layanan <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                </a>
                @auth 
                <a href="/riwayat" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                    Riwayat <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                </a> 
                @endauth
                
                <div class="h-px bg-slate-100 my-1 mx-2"></div>
                
                @if(Auth::check() || Auth::guard('admin')->check())
                     <button onclick="document.getElementById('logout-form').submit();" class="w-full text-left p-3 font-bold text-red-500 bg-red-50 hover:bg-red-100 rounded-xl transition-colors flex items-center justify-between">
                        Logout <i class="ph-bold ph-sign-out"></i>
                    </button>
                @else
                    <a href="/login" class="p-3 font-bold bg-slate-900 text-white text-center rounded-xl hover:bg-slate-800 transition-colors shadow-lg">Login Member</a>
                @endif
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow pt-24 md:pt-32 pb-8 md:pb-12 px-4 md:px-8 max-w-7xl mx-auto w-full z-10">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700 shadow-sm">
                <i class="ph-fill ph-check-circle text-xl shrink-0"></i>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif
        
        {{-- Yield Content --}}
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-white mt-12 md:mt-20 pt-12 md:pt-20 pb-10 rounded-t-[2rem] md:rounded-t-[3rem] relative overflow-hidden">
        
        {{-- Background Effects (Responsive Sizing) --}}
        <div class="absolute inset-0 opacity-10 footer-texture pointer-events-none"></div>
        
        {{-- KUNCI PERBAIKAN: Menggunakan w-[80vw] agar ukuran blob mengikuti lebar layar HP, mencegah overflow --}}
        <div class="absolute -top-24 -left-24 w-[80vw] md:w-96 h-[80vw] md:h-96 bg-brand-500/20 rounded-full blur-[60px] md:blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[60vw] md:w-96 h-[60vw] md:h-96 bg-fresh-500/10 rounded-full blur-[60px] md:blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 md:px-8 relative z-10 footer-safe-area">
           
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 md:gap-12 mb-12 md:mb-16">
               
                {{-- Brand Column --}}
                <div class="lg:col-span-4 space-y-6">
                    <a href="/" class="flex items-center gap-2 group w-fit">
                        <img src="{{ asset('img/logo.webp') }}" alt="Ni Laundry" class="h-8 md:h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                        <span class="text-xl md:text-2xl font-bold tracking-tight">
                            Ni Laundry<span class="text-fresh-400">.</span>
                        </span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Layanan laundry dengan teknologi modern. Kami merawat pakaian Anda dengan standar kebersihan internasional dan pelayanan sepenuh hati.
                    </p>
                    <div class="flex gap-3">
                        <a href="https://www.instagram.com/ni.laundry" target="_blank" aria-label="Instagram" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                        <a href="https://web.facebook.com/profile.php?id=61582451486766#" target="_blank" aria-label="Facebook" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                        <a href="https://wa.me/+6282147556964" target="_blank" aria-label="WhatsApp" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-4 md:space-y-6">
                    <h3 class="font-bold text-lg">Layanan</h3>
                    <ul class="space-y-3 md:space-y-4 text-sm text-slate-400">
                        <li><a href="/layanan" class="hover:text-brand-400 transition-colors flex items-center gap-2 group"><i class="ph-bold ph-caret-right opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0"></i> Cuci Kiloan</a></li>
                        <li><a href="/layanan" class="hover:text-brand-400 transition-colors flex items-center gap-2 group"><i class="ph-bold ph-caret-right opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0"></i> Cuci Satuan</a></li>
                        <li><a href="/layanan" class="hover:text-brand-400 transition-colors flex items-center gap-2 group"><i class="ph-bold ph-caret-right opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0"></i> Cuci Khusus</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2 space-y-4 md:space-y-6">
                    <h3 class="font-bold text-lg">Perusahaan</h3>
                    <ul class="space-y-3 md:space-y-4 text-sm text-slate-400">
                        <li><a href="/#about" class="hover:text-brand-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="https://www.google.com/maps?q=-7.7766983,110.3455633&z=17&hl=en" target="_blank" class="hover:text-brand-400 transition-colors flex items-center gap-2 group">Lokasi Outlet <i class="ph-bold ph-arrow-square-out opacity-0 group-hover:opacity-100 transition-opacity text-xs"></i></a></li>
                        <li><a href="https://wa.me/+6282147556964" target="_blank" class="hover:text-brand-400 transition-colors flex items-center gap-2 group">Kontak Kami <i class="ph-bold ph-arrow-square-out opacity-0 group-hover:opacity-100 transition-opacity text-xs"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© 2025 Ni Laundry. All rights reserved.</p>
            </div>

        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script defer src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script>
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if (sessionStorage.getItem('introShown')) {
                if(preloader) preloader.style.display = 'none';
            } else {
                if(typeof gsap !== 'undefined' && preloader) {
                    const tl = gsap.timeline({
                        onComplete: () => { 
                            preloader.style.display = 'none';
                            sessionStorage.setItem('introShown', 'true');
                        }
                    });
                    tl.to("#loader-bar", { width: "100%", duration: 0.8, ease: "power2.inOut" })
                      .to("#preloader", { opacity: 0, duration: 0.5 });
                }
            }
        });
    </script>
</body>
</html>