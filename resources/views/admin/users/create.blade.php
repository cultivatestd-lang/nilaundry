@extends('layouts.main')
@section('title', 'Tambah Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-8">
        <a href="/admin/users" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-600 transition-colors mb-2">
            <i class="ph-bold ph-arrow-left"></i> Kembali ke Tim
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-glass border border-slate-100 overflow-hidden grid md:grid-cols-5">
        
        <div class="md:col-span-2 bg-slate-900 p-10 text-white relative flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-40 h-40 bg-brand-500 rounded-full blur-[80px] opacity-20"></div>
            
            <div class="relative z-10">

                <h2 class="text-2xl font-bold mb-3">Keamanan Akses</h2>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Menambahkan admin baru berarti memberikan akses penuh ke data keuangan dan pelanggan. Pastikan password kuat.
                </p>
            </div>
        </div>

        <div class="md:col-span-3 p-10 bg-white">
            <h1 class="text-2xl font-bold text-slate-900 mb-8">Registrasi Admin</h1>

            <form action="/admin/users" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Username</label>
                    <div class="relative group">
                        <input type="text" name="username" required placeholder="admin_baru"
                               class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold placeholder:text-slate-400">
                        <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-user-gear text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password</label>
                    <div class="relative group">
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold placeholder:text-slate-400">
                        <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-lock-key text-xl"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 ml-1">Minimal 6 karakter kombinasi angka & huruf.</p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-brand-600 text-white font-bold text-sm shadow-lg hover:shadow-glow hover:-translate-y-1 hover:bg-brand-700 transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Buat Admin</span>
                        <i class="ph-bold ph-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection