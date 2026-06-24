@extends('layouts.main')

@section('title', 'Layanan & Order')

@section('content')

{{-- Container Utama: Flex Row pada Desktop (lg), Flex Col pada Mobile --}}
<div class="flex flex-col lg:flex-row gap-8 items-start relative mt-8"> 
    
    {{-- BAGIAN KIRI: DAFTAR LAYANAN (SCROLLABLE AREA) --}}
    <div class="w-full lg:w-3/5 space-y-8">
        
        {{-- Header Section --}}
        <div data-aos="fade-right">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3 leading-tight text-slate-900">
                Pilih Paket <span class="text-brand-600">Terbaik.</span>
            </h1>
            <p class="text-slate-500 font-medium text-lg max-w-lg leading-relaxed">
                Kami merawat pakaian Anda dengan standar kebersihan tertinggi dan teknologi modern.
            </p>
        </div>

        {{-- Grid Card Layanan --}}
        <div class="grid md:grid-cols-2 gap-5">
            @foreach($layanan as $l)
            
            {{-- LOGIKA DETEKSI ICON BERDASARKAN NAMA LAYANAN --}}
            @php
                $name = strtolower($l->nama_layanan);

                $icon = 'ph-duotone ph-t-shirt';
                $color = 'bg-slate-50 text-slate-600';

                if(str_contains($name, 'setrika')) {
                    $icon = 'mdi mdi-iron-outline';
                    $color = 'bg-orange-50 text-orange-600';
                } elseif(str_contains($name, 'karpet')) {
                    $icon = 'ph-duotone ph-rug';
                    $color = 'bg-red-50 text-red-600';
                } elseif(str_contains($name, 'sepatu') || str_contains($name, 'sneaker')) {
                    $icon = 'ph-duotone ph-sneaker';
                    $color = 'bg-yellow-50 text-yellow-600';
                } elseif(str_contains($name, 'sprei') || str_contains($name, 'bed') || str_contains($name, 'selimut') || str_contains($name, 'bantal')) {
                    $icon = 'ph-duotone ph-bed';
                    $color = 'bg-purple-50 text-purple-600';
                } elseif(str_contains($name, 'boneka')) {
                    $icon = 'ph-duotone ph-finn-the-human';
                    $color = 'bg-pink-50 text-pink-600';
                } elseif(str_contains($name, 'jas') || str_contains($name, 'jaket') || str_contains($name, 'almamater') || str_contains($name, 'dry')) {
                    $icon = 'ph-duotone ph-coat-hanger';
                    $color = 'bg-slate-50 text-slate-600';
                } elseif(str_contains($name, 'tas')) {
                    $icon = 'ph-duotone ph-handbag';
                    $color = 'bg-amber-50 text-amber-600';
                } elseif(str_contains($name, 'reguler') || str_contains($name, 'kilat') || str_contains($name, 'express')) {
                    $icon = 'ph-duotone ph-scales';
                    $color = 'bg-blue-50 text-blue-600';
                } elseif(str_contains($name, 'kemeja') || str_contains($name, 'pcs')) {
                    $icon = 'ph-duotone ph-t-shirt';
                    $color = 'bg-emerald-50 text-emerald-600';
                } elseif(str_contains($name, 'cuci') || str_contains($name, 'tambahan')) {
                    $icon = 'ph-duotone ph-washing-machine';
                    $color = 'bg-teal-50 text-teal-600';
                }
            @endphp

            <div class="group relative bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(59,130,246,0.15)] hover:border-brand-200 hover:-translate-y-2 transition-all duration-500 ease-out h-full flex flex-col justify-between"
                 data-aos="fade-up" 
                 data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl {{ $color }} flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 cubic-bezier(0.34, 1.56, 0.64, 1)">
                        <i class="{{ $icon }}"></i>
                    </div>
                    
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $l->jenis == 'Kiloan' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                        {{ $l->jenis }}
                    </span>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-brand-600 transition-colors duration-300">{{ $l->nama_layanan }}</h3>
                </div>
                
                <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Harga</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold text-slate-800 group-hover:text-brand-600 transition-colors duration-300">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
                            <span class="text-xs text-slate-400 font-medium">/ {{ $l->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}</span>
                        </div>
                    </div>
                    
                    {{-- Tombol (+) untuk memilih layanan --}}
                    <button type="button" 
                            onclick="selectServiceWithAnim(this, '{{ $l->id_layanan }}')" 
                            class="select-btn w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-all shadow-sm group-hover:shadow-md active:scale-90"
                            title="Pilih Layanan Ini">
                        <i class="ph-bold ph-plus transition-transform duration-300"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Info Box --}}
        <div class="p-6 rounded-[2rem] bg-brand-50/50 border border-brand-100 flex gap-4 items-start text-sm text-slate-600"
             data-aos="fade-up" data-aos-delay="200">
            <div class="shrink-0 w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center">
                <i class="ph-fill ph-info text-lg"></i>
            </div>
            <ul class="space-y-1.5 list-disc list-inside mt-1 marker:text-brand-400">
                <li>Waktu pengerjaan standar <span class="font-bold text-brand-700">24-48 jam</span>.</li>
                <li>Berat akan ditimbang ulang secara akurat oleh admin/kurir saat penjemputan.</li>
                <li>Pembayaran dilakukan di akhir (setelah nota keluar).</li>
            </ul>
        </div>
    </div>

    {{-- BAGIAN KANAN: FORM ORDER (Sticky Position) --}}
    <div class="w-full lg:w-2/5 sticky top-28 z-20" data-aos="fade-left" data-aos-duration="800">
        
        <div id="formContainer" class="bg-white/95 md:bg-white/80 md:backdrop-blur-lg rounded-[2.5rem] shadow-lg border border-white/50 p-6 md:p-8 relative overflow-hidden transition-all duration-300">
            
            {{-- Background decoration --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-50 rounded-bl-[5rem] -z-10"></div>

            @auth
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold shadow-md">
                        <i class="ph-bold ph-pencil-simple"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-xl text-slate-900">Form Pesanan</h2>
                        <p class="text-xs text-slate-500 font-medium">Isi data untuk request pickup.</p>
                    </div>
                </div>

                <form id="orderForm" action="{{ route('pesan.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    {{-- Input Layanan --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Layanan</label>
                        <div class="relative">
                            <select id="layananSelect" name="id_layanan" required class="w-full appearance-none bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 outline-none transition-all font-semibold cursor-pointer hover:bg-slate-100">
                                <option value="" disabled selected>Pilih Layanan...</option>
                                @foreach($layanan as $l)
                                    <option value="{{ $l->id_layanan }}">{{ $l->nama_layanan }} (Rp {{ number_format($l->harga, 0) }}/{{ $l->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }})</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 pointer-events-none">
                                <i class="ph-bold ph-caret-down"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Info Berat (Statis) --}}
                    <div class="bg-brand-50 border border-brand-100 rounded-2xl p-4 flex gap-3 items-center">
                        <div class="w-10 h-10 rounded-full bg-white text-brand-600 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="ph-duotone ph-scales text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Berat Dihitung Kurir</h4>
                            <p class="text-xs text-slate-500 leading-tight">Kurir akan menimbang cucian saat sampai di outlet untuk harga akurat.</p>
                        </div>
                    </div>

                    {{-- Input Metode --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Metode</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="Antar Jemput" class="peer sr-only" checked>
                                <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-600 transition-all text-center h-full flex flex-col items-center justify-center gap-1 group">
                                    <i class="ph-duotone ph-moped text-2xl mb-1 group-hover:scale-110 transition-transform"></i>
                                    <span class="text-xs font-bold">Request Pickup</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="Drop Off" class="peer sr-only">
                                <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-600 transition-all text-center h-full flex flex-col items-center justify-center gap-1 group">
                                    <i class="ph-duotone ph-storefront text-2xl mb-1 group-hover:scale-110 transition-transform"></i>
                                    <span class="text-xs font-bold">Antar Sendiri</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-0.5 hover:bg-brand-600 transition-all duration-300 flex items-center justify-center gap-2 mt-4 group">
                        <span>Request Penjemputan</span>
                        <i class="ph-bold ph-paper-plane-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

            @else
                {{-- TAMPILAN JIKA BELUM LOGIN --}}
                <div class="text-center py-8 space-y-6">
                    <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <i class="ph-duotone ph-lock-key text-4xl text-brand-600"></i>
                    </div>
                    
                    <div class="space-y-2">
                        <h2 class="text-2xl font-bold text-slate-800">Login Diperlukan</h2>
                        <p class="text-slate-500 text-sm px-4">
                            Silakan login atau daftar terlebih dahulu untuk melakukan pemesanan laundry.
                        </p>
                    </div>

                    <div class="space-y-3 pt-2">
                        <a href="{{ route('login') }}" class="block w-full py-4 rounded-2xl bg-slate-900 text-white font-bold shadow-lg hover:bg-brand-600 hover:shadow-glow hover:-translate-y-1 transition-all">
                            Login Member
                        </a>
                        <a href="{{ route('register') }}" class="block w-full py-4 rounded-2xl bg-white border-2 border-slate-100 text-slate-700 font-bold hover:border-brand-200 hover:bg-brand-50 hover:text-brand-600 transition-all">
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>
            @endauth

        </div>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT LENGKAP & TERHUBUNG --}}
<script>
    function selectServiceWithAnim(btn, serviceId) {
        const selectBox = document.getElementById('layananSelect');
        const formContainer = document.getElementById('formContainer');

        if(selectBox) {
            selectBox.value = serviceId;

            formContainer.classList.add('ring-4', 'ring-brand-200', 'scale-[1.02]');
            setTimeout(() => {
                formContainer.classList.remove('ring-4', 'ring-brand-200', 'scale-[1.02]');
            }, 400);

            if(window.innerWidth < 1024) {
                formContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk memilih layanan.',
                confirmButtonColor: '#0f172a',
                customClass: { popup: 'rounded-[2rem] p-6' }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const orderForm = document.getElementById('orderForm');

        if(orderForm) {
            orderForm.addEventListener('submit', function(e) {
                e.preventDefault(); 

                const layananSelect = this.querySelector('select[name="id_layanan"]');
                const layananText = layananSelect.options[layananSelect.selectedIndex].text;
                
                Swal.fire({
                    title: 'Konfirmasi Pesanan',
                    text: `Anda akan memesan: ${layananText}. Lanjutkan?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0f172a',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Pesan Sekarang!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-[2rem] p-6',
                        confirmButton: 'px-6 py-3 rounded-xl font-bold',
                        cancelButton: 'px-6 py-3 rounded-xl font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        Swal.fire({
                            title: '',
                            icon: '',
                            width: 400,
                            html: `
                                <div class="flex flex-col items-center justify-center pt-4">
                                    <div class="relative w-20 h-20 mt-6 mb-6">
                                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-14 h-1.5 bg-slate-200 rounded-[100%] blur-sm animate-[pulse_1s_infinite]"></div>
                                        <img src="{{ asset('img/logo.webp') }}" width="40" height="40"
                                            class="w-full h-full object-contain animate-bounce relative z-10"
                                            alt="Loading...">
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800 mb-2">Memproses Pesanan...</h3>
                                    <p class="text-xs text-slate-500">Mohon tunggu sebentar.</p>
                                </div>
                            `,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            background: '#ffffff',
                            customClass: {
                                popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl !p-0 overflow-hidden'
                            }
                        });

                        setTimeout(() => {
                            orderForm.submit();
                        }, 800);
                    }
                });
            });
        }
    });
    
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal Memesan',
            html: `
                <ul class="text-left text-sm text-slate-600 list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            confirmButtonColor: '#0f172a',
            customClass: { popup: 'rounded-[2rem] p-6' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#0f172a',
            customClass: { popup: 'rounded-[2rem] p-6' }
        });
    @endif
</script>

@endsection