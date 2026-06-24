@extends('layouts.main')
@section('title', 'Edit Admin')

@section('content')
<div class="max-w-xl mx-auto">
    
    <div class="mb-8 text-center">
        <a href="/admin/users" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-brand-600 transition-colors mb-4">
            <i class="ph-bold ph-arrow-left"></i> Batal Edit
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Edit Akses</h1>
    </div>

    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-glass border border-white/50 p-10 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand-500 to-fresh-400"></div>

        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold text-slate-600 border-4 border-white shadow-sm">
                {{ substr($admin->username, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold text-slate-900">{{ $admin->username }}</h2>
            <div class="inline-block px-3 py-1 rounded-full bg-slate-50 border border-slate-100 text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-2">
                Administrator
            </div>
        </div>

        <form action="/admin/users/{{ $admin->id_admin }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Username</label>
                <div class="relative group">
                    <input type="text" name="username" value="{{ $admin->username }}" required
                           class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold">
                    <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                        <i class="ph-bold ph-user-gear text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Password Baru</label>
                <div class="relative group">
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diganti"
                           class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold placeholder:font-normal">
                    <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                        <i class="ph-bold ph-lock-key-open text-xl"></i>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 ml-1 italic">*Biarkan kosong jika password tetap sama.</p>
            </div>

            <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-brand-600 text-white font-bold text-sm shadow-lg hover:shadow-glow hover:-translate-y-1 hover:bg-brand-700 transition-all duration-300 flex items-center justify-center gap-2 mt-4">
                <span>Simpan Perubahan</span>
                <i class="ph-bold ph-floppy-disk"></i>
            </button>

        </form>
    </div>
</div>
@endsection