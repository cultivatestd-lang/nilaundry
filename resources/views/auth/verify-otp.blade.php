@extends('layouts.main')
@section('title', 'Verifikasi OTP')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-lg bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-glass border border-white/50 p-8 md:p-12"
         data-aos="zoom-in">
         
         <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-slate-800">Verifikasi & Reset</h1>
            <p class="text-slate-500 text-sm mt-2">Cek WhatsApp Anda, masukkan kode OTP dan password baru.</p>
         </div>

         @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-600 text-sm font-bold flex items-center gap-2">
                <i class="ph-fill ph-check-circle"></i> {{ session('success') }}
            </div>
         @endif
         
         @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 text-rose-600 text-sm font-bold flex items-center gap-2">
                <i class="ph-bold ph-warning-circle"></i> {{ session('error') }}
            </div>
         @endif

         <form action="/reset-password" method="POST" class="space-y-5" x-data="{ show: false }">
            @csrf
            
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Kode OTP (6 Digit)</label>
                <input type="text" name="otp" required placeholder="123456" maxlength="6"
                       class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-center text-2xl tracking-[0.5em] font-mono rounded-2xl focus:bg-white focus:border-brand-500 block p-4 outline-none transition-all">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password Baru</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" required placeholder="Minimal 5 karakter"
                           class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pr-12 outline-none transition-all">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-brand-600">
                        <i class="text-xl" :class="show ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-brand-600 text-white font-bold shadow-lg shadow-brand-200 hover:bg-brand-700 transition-all mt-4">
                Simpan Password Baru
            </button>
         </form>
    </div>
</div>
@endsection