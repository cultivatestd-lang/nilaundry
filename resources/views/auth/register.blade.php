@extends('layouts.main')
@section('title', 'Daftar Member Baru')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-10">
    
    <div class="w-full max-w-5xl bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-glass border border-white/50 overflow-hidden grid lg:grid-cols-2 p-2 relative"
         data-aos="fade-up" 
         data-aos-duration="1000"
         data-aos-easing="ease-out-expo">
        
        <div class="hidden lg:block relative rounded-[2rem] overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1604335399105-a0c585fd81a1?q=80&w=1887&auto=format&fit=crop" 
            alt="Modern Laundry" 
            class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-90 transition-transform duration-1000 group-hover:scale-105">
            
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/60 to-transparent"></div>
            
            <div class="relative z-10 h-full flex flex-col justify-end p-10 text-white">
                <h2 class="text-3xl font-bold leading-tight mb-3" data-aos="fade-right" data-aos-delay="300">
                    Start Your<br>Clean Journey.
                </h2>
                <p class="text-white/90 text-sm font-medium leading-relaxed max-w-xs" data-aos="fade-right" data-aos-delay="400">
                    Bergabunglah sekarang. Antar jemput gratis, bonus poin, dan pakaian yang dirawat sepenuh hati.
                </p>
            </div>
        </div>

        <div class="p-8 md:p-12 flex flex-col justify-center bg-white/50">
            
            <div class="mb-8" data-aos="fade-down" data-aos-delay="200">
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Buat Akun Baru</h1>
                <p class="text-slate-500 font-medium">Lengkapi profil Anda untuk mulai mencuci.</p>
            </div>

            <form action="/register" method="POST" class="space-y-4" x-data="{ showPassword: false }">
                @csrf
                
                <div class="space-y-1.5" data-aos="fade-up" data-aos-delay="300">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <input type="text" name="nama" required placeholder="Nama Lengkap"
                               class="input-focus-effect w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-normal">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-user text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5" data-aos="fade-up" data-aos-delay="400">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">WhatsApp</label>
                    <div class="relative group">
                        <input type="number" name="no_hp" required placeholder="08xxxxxxxxxx"
                               class="input-focus-effect w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-normal">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-whatsapp-logo text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5" data-aos="fade-up" data-aos-delay="500">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Alamat</label>
                    <div class="relative group">
                        <textarea name="alamat" rows="2" required placeholder="Jalan, No Rumah..."
                                  class="input-focus-effect w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-normal resize-none"></textarea>
                        <div class="absolute top-4 left-0 flex items-start px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-map-pin text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5" data-aos="fade-up" data-aos-delay="600">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password</label>
                    <div class="relative group">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder="••••••••"
                               class="input-focus-effect w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 pr-12 outline-none transition-all placeholder:text-slate-400 font-normal">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-lock-key text-xl"></i>
                        </div>
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer outline-none">
                            <i class="text-xl" :class="showPassword ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" id="btn-register" 
                        class="w-full py-4 px-6 rounded-2xl bg-brand-600 text-white font-bold text-sm shadow-lg shadow-brand-200 hover:shadow-glow hover:-translate-y-1 hover:bg-brand-700 transition-all duration-300 flex items-center justify-center gap-2 mt-2"
                        data-aos="fade-up" data-aos-delay="700">
                    <span>Daftar Sekarang</span>
                    <i class="ph-bold ph-arrow-right"></i>
                </button>
            </form>

            <div class="mt-8 text-center pt-6 border-t border-slate-100" data-aos="fade-in" data-aos-delay="800">
                <p class="text-sm font-medium text-slate-500">
                    Sudah punya akun? 
                    <a href="/login" class="font-bold text-brand-600 hover:text-brand-700 underline decoration-2 underline-offset-4 decoration-brand-200 hover:decoration-brand-500 transition-all">
                        Login Disini
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Efek GSAP Bounce kecil saat input diklik
        const inputs = document.querySelectorAll('.input-focus-effect');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                gsap.fromTo(input, 
                    { scale: 0.98 }, 
                    { scale: 1, duration: 0.4, ease: "elastic.out(1, 0.5)" }
                );
            });
        });

        // Efek Magnetic pada Tombol Register
        const btn = document.getElementById('btn-register');
        if(btn) {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                gsap.to(btn, {
                    x: x * 0.1, // Gerakan mengikuti mouse (lemah)
                    y: y * 0.1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { x: 0, y: 0, duration: 0.5, ease: "elastic.out(1, 0.5)" });
            });
        }
    });
</script>
@endsection