@extends('layouts.main')
@section('title', 'Tambah Layanan')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <div class="mb-8">
        <a href="/admin/layanan" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-600 transition-colors mb-2">
            <i class="ph-bold ph-arrow-left"></i> Kembali ke Katalog
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Buat Layanan Baru</h1>
    </div>

    <div class="grid lg:grid-cols-5 gap-8">
        
        <div class="lg:col-span-2 hidden lg:block">
            <div class="bg-brand-600 rounded-[2.5rem] p-10 text-white h-full relative overflow-hidden flex flex-col justify-between">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl mb-6 border border-white/10">
                        <i class="ph-duotone ph-sparkle"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Tips Admin</h3>
                    <p class="text-brand-100 text-sm leading-relaxed mb-6">
                        Pastikan nama layanan jelas dan harga sesuai dengan pasar. Layanan "Kiloan" biasanya untuk pakaian sehari-hari, sedangkan "Satuan" untuk bedcover, jas, atau sepatu.
                    </p>
                </div>

                <div class="relative z-10 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white text-brand-600 flex items-center justify-center font-bold text-xs">?</div>
                        <div class="text-xs font-medium text-brand-50">Gunakan nama unik agar mudah dicari di laporan.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-glass p-8 md:p-10">
                <form action="/admin/layanan" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Layanan</label>
                        <div class="relative group">
                            <input type="text" name="nama_layanan" required placeholder="Contoh: Cuci Komplit (Setrika)"
                                   class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-bold group-hover:border-slate-200">
                            <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                                <i class="ph-bold ph-tag text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jenis Satuan</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis" value="Kiloan" class="peer sr-only" checked>
                                <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-600 transition-all flex flex-col items-center justify-center gap-2 group h-full">
                                    <i class="ph-duotone ph-scales text-2xl text-slate-400 peer-checked:text-brand-500 group-hover:scale-110 transition-transform"></i>
                                    <span class="text-sm font-bold">Kiloan (Kg)</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis" value="Satuan" class="peer sr-only">
                                <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-600 transition-all flex flex-col items-center justify-center gap-2 group h-full">
                                    <i class="ph-duotone ph-t-shirt text-2xl text-slate-400 peer-checked:text-brand-500 group-hover:scale-110 transition-transform"></i>
                                    <span class="text-sm font-bold">Satuan (Pcs)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Harga Dasar</label>
                        <div class="relative group">
                            <input type="number" name="harga" required placeholder="5000"
                                   class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-lg rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-bold group-hover:border-slate-200">
                            <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                                <span class="text-lg font-bold">Rp</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-brand-600 transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Simpan Layanan</span>
                            <i class="ph-bold ph-check"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection