@extends('layouts.main')
@section('title', 'Monitoring Diskon')

@section('content')
<div class="space-y-8">

    <div class="flex flex-col md:flex-row justify-between items-end gap-6 bg-white/60 backdrop-blur-md p-8 rounded-[2.5rem] border border-white/60 shadow-sm relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>

        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Program Diskon</h1>
            <p class="text-slate-500 font-medium">Pantau progres poin dan bonus pelanggan</p>
        </div>

        <div class="relative z-10 flex items-center gap-3 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-fresh-50 text-fresh-600 flex items-center justify-center text-2xl">
                <i class="ph-duotone ph-gift"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Target Bonus</div>
                <div class="text-lg font-bold text-slate-800">8 Kg <span class="text-sm font-normal text-slate-500">= Gratis 1 Kg</span></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-glass overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-8 py-5">Pelanggan</th>
                        <th class="px-6 py-5 w-1/3">Progres Real-time</th>
                        <th class="px-6 py-5">Status Tiket</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($pelanggan as $p)
                    <tr class="hover:bg-brand-50/30 transition-colors group">
                        
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs border border-white shadow-sm">
                                    {{ substr($p->nama, 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">{{ $p->nama }}</div>
                                    <div class="text-xs text-slate-400 font-medium">{{ $p->no_hp }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 align-middle">
                            @php 
                                $target = 8;
                                $capaian = $p->progres_kg;
                                
                                // Hitung Persentase (Maksimal 100%)
                                $persen = ($capaian / $target) * 100;
                                if($persen > 100) $persen = 100;
                            @endphp

                            <div class="flex justify-between items-end mb-2">
                                <div>
                                    <span class="text-2xl font-bold text-slate-800">{{ $capaian }}</span>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">/ {{ $target }} Kg</span>
                                </div>
                                
                                @if($persen >= 100)
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">
                                        <i class="ph-bold ph-check"></i> Tercapai
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-brand-600">{{ round($persen) }}%</span>
                                @endif
                            </div>
                            
                            <div class="relative w-full h-4 bg-slate-100 rounded-full overflow-hidden border border-slate-200 shadow-inner group">
                                
                                <div class="absolute inset-0 z-20 flex w-full h-full px-[12.5%]">
                                    @for($i = 1; $i < 8; $i++)
                                        <div class="w-px h-full bg-white/50 flex-1 border-r border-white/40"></div>
                                    @endfor
                                </div>

                                <div x-data="{ width: 0 }"
                                    x-init="setTimeout(() => width = {{ $persen }}, 300)"
                                    class="h-full rounded-full transition-all duration-[1000ms] ease-out relative z-10
                                            {{ $persen >= 100 ? 
                                            'bg-gradient-to-r from-emerald-400 to-emerald-600 shadow-[0_0_10px_rgba(16,185,129,0.5)]' : 
                                            'bg-gradient-to-r from-amber-300 to-amber-500' 
                                            }}"
                                    :style="`width: ${width}%`">
                                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($capaian < 8)
                                <div class="mt-2 text-[10px] font-medium text-slate-400 flex items-center gap-1">
                                    <i class="ph-fill ph-info"></i>
                                    Kurang <span class="text-slate-600 font-bold">{{ 8 - $capaian }} Kg</span> lagi.
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            @if($p->bonus > 0)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100 shadow-sm animate-pulse">
                                    <i class="ph-fill ph-ticket"></i>
                                    {{ $p->bonus }} Tiket Aktif
                                </div>
                            @else
                                <span class="text-sm font-bold text-slate-300 flex items-center gap-1">
                                    <i class="ph-bold ph-circle"></i> Belum Ada
                                </span>
                            @endif
                        </td>

                        <td class="px-8 py-5 text-right">
                            @if($p->bonus > 0)
                                <form action="/admin/diskon/{{ $p->id_pelanggan }}/reset" method="POST" onsubmit="return confirm('Reset bonus pelanggan ini secara manual?');">
                                    @csrf 
                                    <button class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-500 font-bold text-xs hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm flex items-center gap-2 ml-auto">
                                        <i class="ph-bold ph-arrow-counter-clockwise"></i> Reset
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-200 text-lg">•</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection