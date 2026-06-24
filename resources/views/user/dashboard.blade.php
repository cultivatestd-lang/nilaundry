@extends('layouts.main')
@section('title', 'Beranda')

@section('content')
<div class="space-y-12 md:space-y-20 my-6 md:my-10">

    <div class="grid lg:grid-cols-12 gap-6 items-stretch">
        
        <div class="lg:col-span-7 relative overflow-hidden rounded-[2.5rem] bg-brand-600 shadow-glow group min-h-[350px] md:min-h-[400px] flex items-center" 
             data-aos="fade-right" data-aos-duration="1000">
             
            <img 
                src="https://images.unsplash.com/photo-1604335399105-a0c585fd81a1?q=80&w=1200&auto=format&fit=crop" 
                srcset="
                    https://images.unsplash.com/photo-1604335399105-a0c585fd81a1?q=80&w=600&auto=format&fit=crop 600w,
                    https://images.unsplash.com/photo-1604335399105-a0c585fd81a1?q=80&w=900&auto=format&fit=crop 900w
                "
                sizes="100vw"
                alt="Laundry Background" 
                class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay"
                fetchpriority="high"
            >
            
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900 via-brand-800/80 to-transparent"></div>
            
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/20 blur-[80px] rounded-full group-hover:bg-white/30 transition-colors duration-500"></div>
            
            <div class="relative z-10 p-8 md:p-12 w-full">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-xs font-bold tracking-widest uppercase mb-6 shadow-lg">
                    <span class="w-2 h-2 rounded-full bg-fresh-400 animate-pulse"></span>
                    Welcome Back
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-4 tracking-tight">
                    Halo, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-brand-200">
                        {{ Auth::user()->nama ?? 'Pelanggan' }}!
                    </span>
                </h1>
                
                <p class="text-brand-100 text-lg max-w-md mb-8 leading-relaxed font-medium">
                    Pakaian kotor menumpuk? Tenang, serahkan pada ahlinya. Bersih, wangi, dan rapi dalam sekejap.
                </p>

                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="/layanan" class="magnetic-btn relative px-8 py-4 rounded-2xl bg-white text-brand-700 font-bold shadow-[0_10px_30px_rgba(255,255,255,0.3)] hover:shadow-[0_10px_40px_rgba(255,255,255,0.5)] transition-all flex items-center gap-3 group/btn overflow-hidden">
                            <span class="relative z-10">Mulai Mencuci</span>
                            <i class="ph-bold ph-arrow-right relative z-10 group-hover/btn:translate-x-1 transition-transform"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_1s_infinite]"></div>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white/60 backdrop-blur-2xl border border-white/80 rounded-[2.5rem] p-8 md:p-10 shadow-glass flex flex-col justify-between relative overflow-hidden group"
             data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
            
            <div class="absolute top-0 right-0 w-48 h-48 bg-fresh-400/20 rounded-full blur-[60px] -z-10 group-hover:bg-fresh-400/30 transition-colors"></div>
            
            <div>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h2 class="font-bold text-slate-800 text-lg uppercase tracking-wider">Progres Diskon</h2>
                        </div>
                        <p class="text-slate-500 text-sm font-medium">Kejar diskon spesial Anda.</p>
                    </div>
                    <div class="bg-brand-50 text-brand-600 flex items-center justify-center text-2xl shadow-sm">
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="flex items-end gap-2 mb-4">
                        <span class="text-6xl font-extrabold text-slate-800 tracking-tighter leading-none">
                            {{ Auth::user()->progres_kg ?? 0 }}
                        </span>
                        <span class="text-xl text-slate-400 font-bold mb-1.5">/ 8 Kg</span>
                    </div>
                    
                    <div class="w-full h-6 bg-slate-200/50 rounded-full overflow-hidden border border-slate-100 shadow-inner p-1">
                        @php 
                            $kg = Auth::user()->progres_kg ?? 0;
                            $width = min(($kg / 8) * 100, 100);
                        @endphp
                        <div x-data="{ width: 0 }"
                             x-init="setTimeout(() => width = {{ $width }}, 500)"
                             class="h-full rounded-full transition-all duration-[2000ms] cubic-bezier(0.34, 1.56, 0.64, 1) bg-gradient-to-r from-brand-400 to-brand-600 shadow-[0_0_15px_rgba(59,130,246,0.6)] relative"
                             :style="`width: ${width}%`">
                             <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 w-4 h-4 bg-white rounded-full blur-[2px] shadow-[0_0_10px_white]"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white/50 rounded-2xl p-5 border border-white/60 text-sm text-slate-600 font-medium flex gap-3 items-center backdrop-blur-sm">
                <div class="shrink-0 w-8 h-8 rounded-full bg-fresh-100 text-fresh-600 flex items-center justify-center">
                    <i class="ph-bold ph-gift text-lg"></i>
                </div>
                <p class="leading-snug">
                    Capai <span class="font-bold text-slate-900">8 Kg</span>, dapatkan <span class="font-bold text-brand-600 bg-brand-50 px-1 rounded">Gratis 1 Kg</span> di pesanan selanjutnya!
                </p>
            </div>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-offset="100">
        <div class="text-center mb-12">
                <span class="text-brand-600 font-bold text-3xl uppercase tracking-wider">Kenapa Memilih Kami?</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Layanan Premium, Hasil Maksimal.</h2>
            </div>
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <a href="/layanan" class="group flex items-center gap-2 text-slate-500 hover:text-brand-600 font-bold transition-colors">
                Lihat Semua Layanan <i class="ph-bold ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-sm hover:shadow-glass hover:-translate-y-2 transition-all duration-300 group cursor-default">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-brand-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <i class="ph-duotone ph-moped"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-brand-600 transition-colors">Antar Jemput VIP</h3>
                <p class="text-slate-500 leading-relaxed">Kurir kami menjemput pakaian kotor dan mengantarnya kembali dalam keadaan rapi dan wangi.</p>
            </div>
            
            <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-sm hover:shadow-glass hover:-translate-y-2 transition-all duration-300 group cursor-default">
                <div class="w-16 h-16 rounded-2xl bg-cyan-50 text-fresh-500 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                    <i class="ph-duotone ph-sparkle"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-fresh-500 transition-colors">Eco-Hygiene Wash</h3>
                <p class="text-slate-500 leading-relaxed">Deterjen ramah lingkungan dengan teknologi pembunuh kuman dan bakteri hingga 99%.</p>
            </div>
            
            <div class="p-8 rounded-[2rem] bg-white border border-slate-100 shadow-sm hover:shadow-glass hover:-translate-y-2 transition-all duration-300 group cursor-default">
                <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <i class="ph-duotone ph-timer"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-purple-600 transition-colors">Tepat Waktu</h3>
                <p class="text-slate-500 leading-relaxed">Sistem tracking realtime memastikan cucian Anda selesai tepat sesuai estimasi.</p>
            </div>
        </div>
    </div>

    <div id="about" class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center scroll-mt-32">
        
        <div class="relative group" data-aos="fade-right">
             <div class="rounded-[2rem] md:rounded-[3rem] overflow-hidden border border-slate-100 shadow-glass relative z-10">
               <img 
                    src="https://images.unsplash.com/photo-1582735689369-4fe89db7114c?q=80&w=800&auto=format&fit=crop" 
                    srcset="
                        https://images.unsplash.com/photo-1582735689369-4fe89db7114c?q=80&w=400&auto=format&fit=crop 400w,
                        https://images.unsplash.com/photo-1582735689369-4fe89db7114c?q=80&w=800&auto=format&fit=crop 800w
                    "
                    sizes="(max-width: 600px) 100vw, 50vw"
                    alt="Ni Laundry Service" 
                    loading="lazy" 
                    class="w-full h-[500px] object-cover hover:scale-105 transition-transform duration-300"
                >
            </div>

            <div class="absolute -top-10 -left-10 w-40 h-40 bg-brand-50 rounded-full blur-3xl -z-0"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-fresh-50 rounded-full blur-3xl -z-0"></div>

            <div class="absolute bottom-8 left-8 right-8 z-20 bg-white/80 backdrop-blur-md p-6 rounded-[2rem] border border-white/60 shadow-lg flex items-center gap-4 animate-float">
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">100% Garansi Bersih</h4>
                    <p class="text-xs text-slate-500 font-medium">Jika tidak bersih, kami cuci ulang gratis.</p>
                </div>
            </div>
        </div>

        <div data-aos="fade-left" data-aos-delay="200" class="text-center md:text-left">
            <span class="inline-block px-3 py-1 rounded-full bg-brand-50 text-brand-600 font-bold text-3xl uppercase tracking-wider border border-brand-100 mb-4">
                Tentang Ni Laundry
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6 leading-tight">
                Lebih Dari Sekadar<br>Mencuci Pakaian.
            </h2>
            <p class="text-slate-500 text-lg leading-relaxed mb-8">
                Kami percaya bahwa pakaian yang bersih memberikan kepercayaan diri. Ni Laundry hadir dengan misi menyederhanakan hidup Anda melalui layanan perawatan pakaian berstandar profesional.
            </p>
            </div>
        </div>
    </div>

    <div class="rounded-[3rem] bg-slate-900 overflow-hidden relative p-12 md:p-20 text-center group shadow-2xl"
         data-aos="zoom-in-up" data-aos-offset="150">
         
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] group-hover:scale-110 transition-transform duration-[2000ms]"></div>
        <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-brand-500/20 blur-[150px] rounded-full pointer-events-none"></div>
        
        <div class="relative z-10 max-w-3xl mx-auto">
            <h2 class="text-4xl md:text-3xl font-extrabold text-white mb-6 leading-tight">
                Siap Merasakan<br>Perbedaannya?
            </h2>
            <p class="text-slate-300 text-xl mb-10 font-medium leading-relaxed">
                Nikmati kemudahan layanan laundry premium dalam satu genggaman. Hemat waktu, tenaga, dan biaya.
            </p>
            <a href="/layanan" class="inline-flex px-10 py-5 rounded-2xl bg-white text-slate-900 font-bold text-lg hover:scale-105 hover:shadow-glow transition-all group/cta">
                <span>Pesan Sekarang Juga</span>
                <i class="ph-bold ph-arrow-right ml-2 group-hover/cta:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>

</div>

<style>
    @keyframes shimmer { 
        100% { transform: translateX(100%); } 
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctaBtn = document.getElementById('magnetic-cta');
        if(ctaBtn && typeof gsap !== 'undefined') {
            ctaBtn.addEventListener('mousemove', (e) => {
                const rect = ctaBtn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                gsap.to(ctaBtn, {
                    x: x * 0.2,
                    y: y * 0.2,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            ctaBtn.addEventListener('mouseleave', () => {
                gsap.to(ctaBtn, { x: 0, y: 0, duration: 0.5, ease: "elastic.out(1, 0.5)" });
            });
        }
    });
</script>
@endsection