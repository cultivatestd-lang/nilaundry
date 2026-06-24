@extends('layouts.main')
@section('title', 'Kelola Layanan')

@section('content')
<div class="space-y-8">

    <div class="flex flex-col md:flex-row justify-between items-end gap-4 bg-white/60 backdrop-blur-md p-8 rounded-[2.5rem] border border-white/60 shadow-sm">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Katalog Layanan</h1>
            <p class="text-slate-500 font-medium">Atur jenis laundry dan harga satuan/kiloan.</p>
        </div>
        
        <a href="/admin/layanan/create" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-brand-600 transition-all duration-300 flex items-center gap-2">
            <i class="ph-bold ph-plus"></i>
            <span>Tambah Layanan</span>
        </a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($layanan as $l)
        <div class="group relative bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-glass hover:-translate-y-2 transition-all duration-300 overflow-hidden">
            
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-brand-50 rounded-full blur-2xl group-hover:bg-brand-100 transition-colors"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-colors
                        {{ $l->jenis == 'Kiloan' ? 'bg-blue-50 text-brand-600 group-hover:bg-brand-600 group-hover:text-white' : 'bg-orange-50 text-orange-600 group-hover:bg-orange-500 group-hover:text-white' }}">
                        <i class="ph-duotone {{ $l->jenis == 'Kiloan' ? 'ph-scales' : 'ph-t-shirt' }}"></i>
                    </div>
                    
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
                        <a href="/admin/layanan/{{ $l->id_layanan }}/edit" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-brand-600 hover:border-brand-500 transition-colors shadow-sm" title="Edit">
                            <i class="ph-bold ph-pencil-simple"></i>
                        </a>
                        <form action="/admin/layanan/{{ $l->id_layanan }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:border-rose-500 transition-colors shadow-sm" title="Hapus">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $l->nama_layanan }}</h3>
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider border
                        {{ $l->jenis == 'Kiloan' ? 'bg-blue-50 text-brand-600 border-blue-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                        {{ $l->jenis }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">Regular Service</span>
                </div>

                <div class="flex items-baseline gap-1 pt-4 border-t border-slate-50">
                    <span class="text-2xl font-bold text-slate-800">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                    <span class="text-sm text-slate-400 font-medium">/ {{ $l->jenis == 'Kiloan' ? 'kg' : 'pcs' }}</span>
                </div>
            </div>
        </div>
        @endforeach

        <a href="/admin/layanan/create" class="group rounded-[2.5rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center p-8 hover:border-brand-400 hover:bg-brand-50/30 transition-all cursor-pointer min-h-[250px]">
            <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center text-3xl mb-4 group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                <i class="ph-bold ph-plus"></i>
            </div>
            <span class="font-bold text-slate-400 group-hover:text-brand-600 transition-colors">Tambah Layanan Baru</span>
        </a>
    </div>

</div>
@endsection