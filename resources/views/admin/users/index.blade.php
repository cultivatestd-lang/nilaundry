@extends('layouts.main')
@section('title', 'Kelola Admin')

@section('content')
<div class="space-y-8">

    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Tim Administrator</h1>
            <p class="text-slate-500 font-medium">Kelola akses keamanan dashboard.</p>
        </div>
        <a href="/admin/users/create" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-brand-600 transition-all flex items-center gap-2">
            <i class="ph-bold ph-user-plus"></i> Tambah Admin
        </a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($admins as $a)
        <div class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm hover:shadow-glass hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
            
            @if(Auth::guard('admin')->id() == $a->id_admin)
                <span class="absolute top-6 right-6 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-[10px] font-bold uppercase tracking-wider border border-brand-100">
                    It's You
                </span>
            @endif

            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-2xl font-bold text-slate-600 mb-6 shadow-inner group-hover:from-brand-100 group-hover:to-fresh-100 group-hover:text-brand-600 transition-colors">
                {{ substr($a->username, 0, 1) }}
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $a->username }}</h3>
            <p class="text-sm text-slate-400 font-medium mb-6">Administrator Access</p>

            <div class="flex items-center gap-3 pt-6 border-t border-slate-50">
                <a href="/admin/users/{{ $a->id_admin }}/edit" class="flex-1 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-xs font-bold text-center hover:bg-brand-50 hover:text-brand-600 hover:border-brand-200 transition-all shadow-sm">
                    Edit Akun
                </a>

                @if(Auth::guard('admin')->id() != $a->id_admin)
                <form action="/admin/users/{{ $a->id_admin }}" method="POST" onsubmit="return confirm('Hapus admin ini?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button class="w-full py-2.5 rounded-xl bg-white border border-slate-200 text-rose-500 text-xs font-bold hover:bg-rose-50 hover:border-rose-200 transition-all shadow-sm">
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach

        <a href="/admin/users/create" class="rounded-[2.5rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center p-8 hover:border-brand-400 hover:bg-brand-50/30 transition-all cursor-pointer min-h-[200px] group">
            <div class="w-14 h-14 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center text-2xl mb-4 group-hover:bg-brand-100 group-hover:text-brand-600 transition-colors">
                <i class="ph-bold ph-plus"></i>
            </div>
            <span class="font-bold text-slate-400 group-hover:text-brand-600 transition-colors">Tambah Baru</span>
        </a>
    </div>

</div>
@endsection