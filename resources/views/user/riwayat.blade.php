@extends('layouts.main')
@section('title', 'Riwayat Pesanan')

@section('content')

{{-- 1. SCRIPT MIDTRANS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<div class="max-w-6xl mx-auto my-8 space-y-10">

    {{-- HEADER SECTION --}}
    <div class="relative overflow-hidden bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-8 md:p-12 shadow-glass flex flex-col md:flex-row items-center justify-between gap-6 group isolate"
         data-aos="fade-down" data-aos-duration="800">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-100/60 rounded-full blur-[80px] -mr-16 -mt-16 pointer-events-none -z-10"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-fresh-100/60 rounded-full blur-[60px] -ml-10 -mb-10 pointer-events-none -z-10"></div>
        
        <div class="relative z-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-slate-500 font-medium text-lg">Pantau status laundry dan pembayaran Anda.</p>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row gap-4 items-center">
            <div class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-white border border-slate-100 shadow-sm transition-all hover:scale-105 hover:shadow-md duration-300 cursor-default">
                <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center text-xl">
                    <i class="ph-fill ph-receipt"></i>
                </div>
                <div class="text-left">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Order</span>
                    <span class="block text-xl font-bold text-slate-800">{{ $pesanan->count() }}</span>
                </div>
            </div>

            <a href="/layanan" class="px-6 py-3 rounded-2xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 transition-all flex items-center gap-2 shadow-lg shadow-brand-200 hover:-translate-y-1 active:scale-95">
                <i class="ph-bold ph-plus"></i> Pesan Baru
            </a>
        </div>
    </div>

    {{-- GRID LAYOUT PESANAN --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse($pesanan as $p)

        @php
            $total       = $p->total_harga;
            $sudah_bayar = $p->jumlah_bayar ?? 0;
            $sisa        = $total - $sudah_bayar;
            
            $isLunas     = $sisa <= 0 && $total > 0;
            $isDP        = $sudah_bayar > 0 && !$isLunas; 
            $isGratis    = $total == 0 && $p->berat > 0;

            $name = strtolower($p->layanan->nama_layanan ?? '');
            $icon = 'ph-duotone ph-basket'; 
            $color = 'bg-brand-50 text-brand-600';

            if(str_contains($name, 'setrika')) { $icon = 'mdi mdi-iron-outline'; $color = 'bg-orange-50 text-orange-600'; } 
            elseif(str_contains($name, 'karpet')) { $icon = 'ph-duotone ph-rug'; $color = 'bg-red-50 text-red-600'; } 
            elseif(str_contains($name, 'sepatu') || str_contains($name, 'sneaker')) { $icon = 'ph-duotone ph-sneaker'; $color = 'bg-yellow-50 text-yellow-600'; } 
            elseif(str_contains($name, 'sprei') || str_contains($name, 'selimut')) { $icon = 'ph-duotone ph-bed'; $color = 'bg-purple-50 text-purple-600'; } 
            elseif(str_contains($name, 'boneka')) { $icon = 'ph-duotone ph-finn-the-human'; $color = 'bg-pink-50 text-pink-600'; } 
            elseif(str_contains($name, 'jas') || str_contains($name, 'jaket')) { $icon = 'ph-duotone ph-coat-hanger'; $color = 'bg-slate-50 text-slate-600'; } 
            elseif(str_contains($name, 'tas')) { $icon = 'ph-duotone ph-handbag'; $color = 'bg-amber-50 text-amber-600'; } 
            elseif(str_contains($name, 'reguler') || str_contains($name, 'kilat')) { $icon = 'ph-duotone ph-scales'; $color = 'bg-blue-50 text-blue-600'; } 
            elseif(str_contains($name, 'kemeja') || str_contains($name, 'pcs')) { $icon = 'ph-duotone ph-t-shirt'; $color = 'bg-emerald-50 text-emerald-600'; }
        @endphp

        {{-- CARD ITEM --}}
        <div class="group relative bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(59,130,246,0.15)] hover:border-brand-200 hover:-translate-y-2 transition-all duration-500 ease-out flex flex-col h-full"
             data-aos="fade-up"
             data-aos-delay="{{ ($loop->index % 4) * 150 }}">
            
            {{-- Bagian Atas --}}
            <div class="flex justify-between items-start mb-6 pb-4 border-b border-slate-50 group-hover:border-slate-100 transition-colors">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Order ID</span>
                    <span class="font-mono text-sm font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        #{{ str_pad($p->id_pesanan, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="text-right">
                     <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tanggal</span>
                     <span class="text-xs font-bold text-slate-600 flex items-center gap-1 justify-end">
                        <i class="ph-bold ph-calendar-blank text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300"></i>
                        {{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}
                     </span>
                </div>
            </div>

            {{-- Bagian Tengah --}}
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl shrink-0 flex items-center justify-center text-2xl {{ $color }} group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 cubic-bezier(0.34, 1.56, 0.64, 1) shadow-sm">
                    <i class="{{ $icon }}"></i>
                </div>
                
                <div>
                    <h3 class="font-bold text-slate-800 text-lg leading-tight mb-2 group-hover:text-brand-600 transition-colors duration-300">
                        {{ $p->layanan->nama_layanan }}
                    </h3>
                    
                    <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500">
                        @if($p->status_pesanan == 'Dibatalkan')
                             <span class="bg-red-50 text-red-600 px-2 py-0.5 rounded border border-red-100 flex items-center gap-1">
                                <i class="ph-bold ph-x-circle"></i> Batal
                            </span>
                        @elseif($p->status_pesanan == 'Dikembalikan')
                             <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded border border-slate-200 flex items-center gap-1">
                                <i class="ph-bold ph-arrow-u-up-left"></i> Refunded
                            </span>
                        @elseif($p->berat == 0)
                            <span class="bg-amber-50 text-amber-600 px-2 py-0.5 rounded border border-amber-100 flex items-center gap-1">
                                <i class="ph-bold ph-scales"></i> Sedang Ditimbang
                            </span>
                        @else
                            <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100 font-bold text-slate-700">
                                {{ $p->berat }} {{ $p->layanan->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}
                            </span>
                        @endif

                        <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                            {{ $p->metode }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bagian Status --}}
            <div class="mb-6 space-y-2">
                <div class="flex justify-between items-center text-sm group-hover:translate-x-1 transition-transform duration-300 ease-out">
                    <span class="text-slate-400 font-medium text-xs uppercase">Status</span>
                    
                    @if($p->status_pesanan == 'Pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200 shadow-sm">
                            <i class="ph-bold ph-hourglass"></i> Menunggu Konfirmasi
                        </span>

                    @elseif($p->status_pesanan == 'Menunggu Pembayaran')
                        {{-- Logika Badge Khusus DP --}}
                        @if($isDP)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-xs font-bold border border-orange-100 shadow-sm">
                                <i class="ph-fill ph-coins"></i> Kurang Bayar (DP)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100 shadow-sm">
                                <span class="relative flex h-2 w-2 mr-0.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                </span> Menunggu Bayar
                            </span>
                        @endif

                    @elseif($p->status_pesanan == 'Diproses')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold border border-brand-100 shadow-sm">
                             <i class="ph-bold ph-spinner animate-spin text-brand-500"></i> Diproses
                        </span>

                    @elseif($p->status_pesanan == 'Selesai')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100 shadow-sm">
                            <i class="ph-bold ph-check-circle text-emerald-500"></i> Selesai
                        </span>
                        
                    @elseif($p->status_pesanan == 'Dibatalkan')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold border border-red-100 shadow-sm">
                            <i class="ph-bold ph-x-circle text-red-500"></i> Dibatalkan
                        </span>
                    @elseif($p->status_pesanan == 'Dikembalikan')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200 shadow-sm">
                            <i class="ph-bold ph-arrow-u-up-left"></i> Dikembalikan
                        </span>
                    @endif
                </div>
            </div>

            {{-- Bagian Bawah: Harga & Aksi --}}
            <div class="mt-auto pt-4 border-t border-dashed border-slate-200 flex flex-col gap-4 group-hover:border-brand-200 transition-colors">
                <div class="flex justify-between items-end">
                    
                    {{-- LABEL HARGA (DINAMIS SISA/TOTAL) --}}
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ $isDP ? 'Sisa Tagihan' : 'Total Tagihan' }}
                        </span>
                        @if($isDP)
                            <span class="text-[10px] text-slate-400 font-medium">Total: Rp {{ number_format($total, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <div class="text-right">
                        @if($p->status_pesanan == 'Pending')
                             <span class="text-sm font-bold text-slate-400">Menunggu Admin</span>
                        
                        @elseif($p->status_pesanan == 'Dibatalkan' || $p->status_pesanan == 'Dikembalikan')
                             <span class="text-sm font-bold text-red-400 line-through">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        
                        @elseif($isGratis)
                             <span class="text-xl font-bold text-emerald-500 animate-pulse">GRATIS</span>
                        @else
                            {{-- LOGIKA NOMINAL: TAMPILKAN SISA JIKA DP --}}
                            <span class="text-xl font-bold {{ $isDP ? 'text-rose-600' : 'text-slate-800' }} group-hover:text-brand-600 transition-colors">
                                Rp {{ number_format($isDP ? $sisa : $total, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- LOGIKA TOMBOL AKSI UTAMA (UPDATED) --}}
                {{-- ========================================== --}}

                {{-- 1. JIKA STATUS PENDING -> BOLEH BATALKAN --}}
                @if($p->status_pesanan == 'Pending')
                    <div class="flex flex-col gap-2">
                        <div class="w-full py-2.5 text-center text-xs text-slate-500 font-medium bg-slate-50 rounded-xl border border-slate-200">
                            Menunggu konfirmasi laundry...
                        </div>
                        
                        <form id="form-batal-{{ $p->id_pesanan }}" action="/pesanan/cancel/{{ $p->id_pesanan }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="konfirmasiBatal({{ $p->id_pesanan }})" class="w-full py-2 rounded-xl text-red-500 font-bold text-xs hover:bg-red-50 transition-all border border-transparent hover:border-red-100 flex items-center justify-center gap-1 group/cancel">
                                <i class="ph-bold ph-trash group-hover/cancel:scale-110 transition-transform"></i> Batalkan Pesanan
                            </button>
                        </form>
                    </div>

                {{-- 2. JIKA BELUM LUNAS (BAIK ITU FULL BELUM BAYAR ATAU DP) --}}
                {{-- Syarat: Ada Tagihan, Sisa Tagihan > 0, Tidak Batal/Dikembalikan --}}
                @elseif($total > 0 && $sisa > 0 && !in_array($p->status_pesanan, ['Dibatalkan', 'Dikembalikan']))
                    
                    <button onclick="bayarSekarang({{ $p->id_pesanan }})" 
                            id="btn-bayar-{{ $p->id_pesanan }}"
                            class="w-full py-3 rounded-xl bg-slate-900 text-white font-bold text-sm shadow-lg shadow-slate-200 hover:bg-brand-600 hover:shadow-brand-300 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-2 relative overflow-hidden group/btn">
                        <span class="absolute inset-0 bg-white/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                        <i class="ph-bold ph-credit-card relative z-10"></i> 
                        <span class="relative z-10">
                            {{ $isDP ? 'Lunasi Sisa Tagihan' : 'Bayar Sekarang' }}
                        </span>
                    </button>

                {{-- 3. JIKA SUDAH LUNAS --}}
                @elseif($isLunas)
                    <div class="w-full py-2.5 text-center text-xs text-emerald-600 font-bold bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-center gap-1">
                        <i class="ph-bold ph-check-circle"></i> Lunas
                    </div>
                    
                    @if($p->status_pesanan == 'Selesai')
                         <a href="/layanan" class="w-full py-2.5 rounded-xl border-2 border-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:border-slate-200 hover:text-slate-900 active:scale-95 transition-all text-center block">
                            Pesan Lagi
                        </a>
                    @endif

                {{-- 4. JIKA DIBATALKAN / DIKEMBALIKAN --}}
                @elseif($p->status_pesanan == 'Dibatalkan' || $p->status_pesanan == 'Dikembalikan')
                    <div class="w-full py-2.5 text-center text-xs text-slate-400 font-medium bg-slate-50 rounded-xl border border-slate-200">
                        Tidak ada tagihan aktif
                    </div>
                @endif
            </div>

        </div>
        
        @empty
        <div class="col-span-full py-24 text-center flex flex-col items-center justify-center bg-white/50 border-2 border-dashed border-slate-200 rounded-[2.5rem]"
             data-aos="zoom-in" data-aos-duration="600">
            <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mb-6 shadow-inner animate-[bounce_3s_ease-in-out_infinite]">
                <i class="ph-duotone ph-basket text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Pesanan</h3>
            <p class="text-slate-500 max-w-xs mx-auto mb-8">Riwayat pesanan Anda akan muncul di sini.</p>
            <a href="/layanan" class="px-8 py-3 rounded-xl bg-brand-600 text-white font-bold hover:bg-brand-700 hover:scale-105 active:scale-95 transition-all shadow-lg">
                <i class="ph-bold ph-plus"></i> Buat Pesanan Baru
            </a>
        </div>
        @endforelse

    </div>
</div>

{{-- SCRIPT JAVASCRIPT LENGKAP --}}
<script type="text/javascript">
    
    function konfirmasiBatal(idPesanan) {
        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: "Apakah Anda yakin ingin membatalkan pesanan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', 
            cancelButtonColor: '#64748b', 
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-xl',
                confirmButton: 'rounded-xl px-6 py-2.5 font-bold shadow-md',
                cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                
                Swal.fire({
                    html: `
                        <div class="flex flex-col items-center justify-center pt-4">
                            <div class="relative w-20 h-20 mt-6 mb-6">
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-14 h-1.5 bg-slate-200 rounded-[100%] blur-sm animate-[pulse_1s_infinite]"></div>
                                <img src="{{ asset('img/logo.webp') }}" width="40" height="40"
                                     class="w-full h-full object-contain animate-bounce relative z-10"
                                     alt="Cancelling...">
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Membatalkan...</h3>
                            <p class="text-xs text-slate-500">Sedang memproses pembatalan pesanan.</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl !p-0 overflow-hidden'
                    }
                });

                setTimeout(() => {
                    document.getElementById('form-batal-' + idPesanan).submit();
                }, 800);
            }
        });
    }


    async function bayarSekarang(idPesanan) {
        
        Swal.fire({
            html: `
                <div class="flex flex-col items-center justify-center pt-4">
                    <div class="relative w-20 h-20 mt-6 mb-6">
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-14 h-1.5 bg-slate-200 rounded-[100%] blur-sm animate-[pulse_1s_infinite]"></div>
                        <img src="{{ asset('img/logo.webp') }}" width="40" height="40"
                             class="w-full h-full object-contain animate-bounce relative z-10"
                             alt="Loading...">
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Menyiapkan Pembayaran...</h3>
                    <p class="text-xs text-slate-500">Mohon tunggu sebentar.</p>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            background: '#ffffff',
            customClass: {
                popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl !p-0 overflow-hidden'
            }
        });

        try {
            const response = await fetch('/pesanan/bayar/' + idPesanan);
            const data = await response.json();

            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error,
                    confirmButtonColor: '#0f172a',
                    customClass: { popup: 'rounded-[2rem]' }
                });
                return;
            }

            setTimeout(() => {
                Swal.close(); 
                window.snap.pay(data.snapToken, {
                    onSuccess: function(result){
                        window.location.href = "/pesanan/sukses/" + data.order_id;
                    },
                    onPending: function(result){
                        Swal.fire('Info', 'Menunggu pembayaran diselesaikan!', 'info').then(() => location.reload());
                    },
                    onError: function(result){
                        Swal.fire('Gagal', 'Pembayaran gagal atau dibatalkan!', 'error');
                    }
                });
            }, 500);

        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Error',
                text: 'Gagal menghubungkan ke server.',
                confirmButtonColor: '#0f172a'
            });
        }
    }
</script>

@endsection