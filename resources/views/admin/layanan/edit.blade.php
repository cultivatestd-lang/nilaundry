@extends('layouts.main')
@section('title', 'Edit Layanan')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <a href="/admin/layanan" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-600 transition-colors mb-2">
                <i class="ph-bold ph-arrow-left"></i> Batal Edit
            </a>
            <h1 class="text-3xl font-bold text-slate-900">Edit Layanan</h1>
        </div>
        <div class="px-3 py-1 bg-brand-50 text-brand-600 text-xs font-bold rounded-lg uppercase tracking-wider">
            ID: {{ $layanan->id_layanan }}
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-glass p-8 md:p-10 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

        <form action="/admin/layanan/{{ $layanan->id_layanan }}" method="POST" class="space-y-6 relative z-10">
            @csrf @method('PUT')
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Layanan</label>
                <div class="relative group">
                    <input type="text" name="nama_layanan" value="{{ $layanan->nama_layanan }}" required
                           class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold group-hover:border-slate-200">
                    <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                        <i class="ph-bold ph-tag text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jenis Satuan</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="jenis" value="Kiloan" class="peer sr-only" {{ $layanan->jenis == 'Kiloan' ? 'checked' : '' }}>
                        <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-600 transition-all flex flex-col items-center justify-center gap-2 group h-full">
                            <i class="ph-duotone ph-scales text-2xl text-slate-400 peer-checked:text-brand-500 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm font-bold">Kiloan (Kg)</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="jenis" value="Satuan" class="peer sr-only" {{ $layanan->jenis == 'Satuan' ? 'checked' : '' }}>
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
                    <input type="number" name="harga" value="{{ $layanan->harga }}" required
                           class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-lg rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold group-hover:border-slate-200">
                    <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                        <span class="text-lg font-bold">Rp</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="/admin/layanan" class="w-1/3 py-4 rounded-2xl border-2 border-slate-100 text-slate-500 font-bold text-sm hover:bg-slate-50 hover:text-slate-800 transition-all text-center flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="w-2/3 py-4 px-6 rounded-2xl bg-brand-600 text-white font-bold text-sm shadow-lg hover:shadow-glow hover:-translate-y-1 hover:bg-brand-700 transition-all duration-300 flex items-center justify-center gap-2">
                    <span>Update Perubahan</span>
                    <i class="ph-bold ph-floppy-disk"></i>
                </button>
            </div>

        </form>
    </div>
</div>
@endsection