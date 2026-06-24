@extends('layouts.main')
@section('title', 'Lupa Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-lg bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-glass border border-white/50 p-8 md:p-12 relative overflow-hidden"
         data-aos="fade-up">
         
         <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-[#25D366]/10 text-[#25D366] rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="ph-fill ph-whatsapp-logo"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Kirim Kode OTP</h1>
            <p class="text-slate-500 text-sm mt-2">Masukkan nomor WhatsApp yang terdaftar.</p>
         </div>

         @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 text-rose-600 text-sm font-bold flex items-center gap-2">
                <i class="ph-bold ph-warning-circle"></i> {{ session('error') }}
            </div>
         @endif

         <form action="/forgot-password" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nomor WhatsApp</label>
                <div class="relative group">
                    <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx"
                           class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold">
                    <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400">
                        <i class="ph-bold ph-phone text-xl"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-brand-600 text-white font-bold shadow-lg shadow-brand-200 hover:shadow-glow hover:-translate-y-1 transition-all">
                Kirim Kode OTP
            </button>
         </form>
         
         <div class="mt-6 text-center">
             <a href="/login" class="text-sm font-bold text-slate-400 hover:text-brand-600 transition-colors">Kembali ke Login</a>
         </div>
    </div>
</div>
@endsection