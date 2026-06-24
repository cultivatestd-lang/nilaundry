@extends('layouts.main')
@section('title', 'Login Administrator')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center relative">
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-glass border border-white/60 p-10 md:p-12 text-center">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Admin Portal</h1>
                <p class="text-slate-500 text-sm mt-2">Masuk untuk mengelola pesanan & pelanggan.</p>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-sm font-medium flex items-center justify-center gap-2">
                    <i class="ph-bold ph-warning-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="/admin/login" method="POST" class="space-y-4" x-data="{ showPassword: false }">
                @csrf
                
                <div class="text-left space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Username</label>
                    <div class="relative group">
                        <input type="text" name="username" required placeholder="admin"
                               class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-slate-900 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-bold font-mono">
                    </div>
                </div>

                <div class="text-left space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password</label>
                    <div class="relative group">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder="••••••••"
                               class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-slate-900 block p-4 pl-12 pr-12 outline-none transition-all placeholder:text-slate-400 font-bold font-mono">
                        
                        <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-slate-900 transition-colors">
                            <i class="ph-bold ph-lock-key text-xl"></i>
                        </div>
                        
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer outline-none">
                            <i class="text-xl" :class="showPassword ? 'ph-bold ph-eye-slash' : 'ph-bold ph-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-slate-800 transition-all duration-300 flex items-center justify-center gap-2 mt-6">
                    <span>Masuk Dashboard</span>
                    <i class="ph-bold ph-arrow-right"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <a href="/login" class="text-xs font-bold text-slate-400 hover:text-brand-600 transition-colors">
                    <i class="ph-bold ph-arrow-left mr-1"></i> Kembali ke Login Member
                </a>
            </div>
        </div>
    </div>
</div>
@endsection