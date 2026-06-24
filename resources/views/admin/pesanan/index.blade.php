@extends('layouts.main')
@section('title', 'Kelola Pesanan')

@section('content')
<div class="space-y-8">

    {{-- HEADER & LEGEND STATUS (TETAP SAMA) --}}
    <div class="flex flex-col xl:flex-row justify-between items-end gap-6 bg-white/60 backdrop-blur-md p-8 rounded-[2.5rem] border border-white/60 shadow-sm">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Manajemen Pesanan</h1>
            <p class="text-slate-500 font-medium">Kelola semua transaksi laundry yang masuk.</p>
        </div>
        
        <div class="flex flex-wrap gap-2 justify-end">
            {{-- Legend Items (Sama) --}}
            <div class="px-3 py-1.5 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Pending</span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Belum Bayar</span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Diproses</span>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Selesai</span>
            </div>
             <div class="px-3 py-1.5 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Batal/Refund</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden relative">
        
        {{-- SEARCH BAR (TETAP SAMA) --}}
        <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/30">
            <form action="{{ url()->current() }}" method="GET" class="relative w-full md:max-w-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID, Nama, atau Status..." class="w-full bg-white border border-slate-200 rounded-xl py-3 pl-10 pr-4 text-sm font-bold focus:outline-none focus:border-brand-500 transition-all shadow-sm">
                <button type="submit" class="absolute inset-y-0 left-0 flex items-center px-3 text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="ph-bold ph-magnifying-glass"></i>
                </button>
            </form>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                Total: {{ $pesanan->count() }} Transaksi
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-8 py-5">ID & Tanggal</th>
                        <th class="px-6 py-5">Pelanggan</th>
                        <th class="px-6 py-5">Layanan & Berat</th>
                        <th class="px-6 py-5">Tagihan & Status Bayar</th>
                        <th class="px-6 py-5">Status Pengerjaan</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($pesanan as $p)
                    <tr class="transition-colors group {{ $p->status_pesanan == 'Dibatalkan' || $p->status_pesanan == 'Dikembalikan' ? 'bg-slate-50 opacity-70 grayscale-[50%]' : ($p->berat == 0 ? 'bg-rose-50/30 hover:bg-rose-50/50' : ($p->status_pesanan == 'Menunggu Pembayaran' ? 'bg-amber-50/20 hover:bg-amber-50/40' : 'hover:bg-brand-50/30')) }}">
                        
                        {{-- 1. ID & TANGGAL --}}
                        <td class="px-8 py-5 align-top">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs group-hover:bg-brand-500 group-hover:text-white transition-colors">
                                    #{{ str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- 2. PELANGGAN --}}
                        <td class="px-6 py-5 align-top">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-100 to-fresh-100 flex items-center justify-center text-brand-600 font-bold text-xs border border-white shadow-sm">
                                    {{ substr($p->pelanggan->nama ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-700 text-sm">{{ $p->pelanggan->nama ?? 'User Terhapus' }}</div>
                                    <div class="text-xs text-slate-400 font-medium">{{ $p->metode }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- 3. LAYANAN & BERAT --}}
                        <td class="px-6 py-5 align-top">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 mb-1">
                                {{ $p->layanan->jenis }}
                            </span>
                            <div class="text-sm font-bold text-slate-800">{{ $p->layanan->nama_layanan }}</div>
                            
                            @if($p->berat == 0 && $p->status_pesanan != 'Dibatalkan')
                                <div class="inline-flex items-center gap-1 mt-1 px-2 py-1 rounded bg-rose-100 text-rose-600 text-[10px] font-bold uppercase tracking-wide animate-pulse">
                                    <i class="ph-bold ph-scales"></i> Belum Ditimbang
                                </div>
                            @elseif($p->status_pesanan == 'Dibatalkan')
                                <div class="text-xs text-slate-400 line-through mt-1">Berat: {{ $p->berat }}</div>
                            @else
                                <div class="text-xs text-slate-500 font-bold mt-1">
                                    Berat: <span class="text-slate-900">{{ $p->berat }} {{ $p->layanan->jenis == 'Satuan' ? 'Pcs' : 'Kg' }}</span>
                                </div>
                            @endif
                        </td>

                        {{-- 4. TAGIHAN & PEMBAYARAN --}}
                        <td class="px-6 py-5 align-top">
                            @php
                                $sisaTagihan = $p->total_harga - ($p->jumlah_bayar ?? 0);
                                $isLunas = $sisaTagihan <= 0;
                                $isDP = $p->jumlah_bayar > 0 && !$isLunas;
                            @endphp

                            @if($p->status_pesanan == 'Dibatalkan')
                                <span class="text-xs font-bold text-red-400 line-through block">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-bold text-red-500 uppercase">Dibatalkan</span>
                            
                            @elseif($p->status_pesanan == 'Dikembalikan')
                                <span class="text-xs font-bold text-slate-400 line-through block">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-red-100 text-red-600 text-[10px] font-bold border border-red-200">
                                    <i class="ph-bold ph-arrow-u-up-left"></i> REFUNDED
                                </span>

                            @elseif($p->berat == 0)
                                <div class="text-xs font-bold text-slate-400 italic">Menunggu timbangan...</div>
                            
                            @elseif($p->total_harga == 0)
                                <span class="inline-block px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 font-bold text-xs border border-emerald-100">GRATIS</span>
                            
                            @else
                                {{-- Tampilan Nominal --}}
                                <div class="font-bold text-slate-900 text-sm">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</div>

                                @if($isLunas)
                                    <div class="flex items-center gap-1 text-[10px] font-bold text-emerald-500 mt-1">
                                        <i class="ph-fill ph-check-circle"></i> Lunas
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-medium">Total: Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</div>
                                @else
                                    {{-- Tampilan Status Belum Lunas / DP --}}
                                    @if($isDP)
                                        <div class="flex items-center gap-1 text-[10px] font-bold text-amber-500 mt-1">
                                            <i class="ph-fill ph-coin"></i> DP: Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[10px] text-rose-500 font-bold mt-0.5">Kurang: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</div>
                                    @else
                                        <div class="flex items-center gap-1 text-[10px] font-bold text-slate-400 mt-1">
                                            <i class="ph-fill ph-clock"></i> Belum Bayar
                                        </div>
                                    @endif

                                    {{-- TOMBOL TRIGGER MODAL BAYAR --}}
                                    <div class="mt-2">
                                        <button type="button" 
                                            onclick="openPaymentModal({{ $p->id_pesanan }}, {{ $p->total_harga }}, {{ $p->jumlah_bayar ?? 0 }})"
                                            class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-lg transition-all text-[10px] font-bold uppercase tracking-wide border border-emerald-200 hover:border-emerald-600 shadow-sm w-full justify-center group-btn">
                                            <span>{{ $isDP ? 'Lunasi Sisa' : 'Bayar Tunai' }}</span>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        </td>

                        {{-- 5. STATUS DROPDOWN --}}
                        <td class="px-6 py-5 align-top">
                            @if($p->status_pesanan == 'Dikembalikan')
                                <div class="w-full px-4 py-2 rounded-xl text-xs font-bold bg-red-50 text-red-700 border border-red-100 flex items-center gap-2 cursor-not-allowed opacity-80">
                                    <i class="ph-bold ph-arrow-u-up-left"></i> Dana Dikembalikan
                                </div>
                            @else
                                <form action="/admin/pesanan/{{ $p->id_pesanan }}/update-status" method="POST">
                                    @csrf
                                    <div class="relative w-44"> 
                                        <select name="status_pesanan" onchange="this.form.submit()" {{ ($p->berat == 0 && $p->status_pesanan != 'Dibatalkan') ? 'disabled' : '' }} class="w-full appearance-none cursor-pointer pl-9 pr-8 py-2 rounded-xl text-xs font-bold border outline-none transition-all shadow-sm {{ $p->berat == 0 && $p->status_pesanan != 'Dibatalkan' ? 'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed' : ($p->status_pesanan == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-100 hover:bg-emerald-100' : ($p->status_pesanan == 'Diproses' ? 'bg-brand-50 text-brand-700 border-brand-100 hover:bg-brand-100' : ($p->status_pesanan == 'Menunggu Pembayaran' ? 'bg-amber-50 text-amber-700 border-amber-100 hover:bg-amber-100' : ($p->status_pesanan == 'Dibatalkan' ? 'bg-red-50 text-red-700 border-red-100' : 'bg-slate-50 text-slate-700 border-slate-100 hover:bg-slate-100')))) }}">
                                            <option value="Pending" {{ $p->status_pesanan == 'Pending' ? 'selected' : '' }}>{{ $p->berat == 0 ? 'Input Berat Dulu' : 'Menunggu Konfirmasi' }}</option>
                                            <option value="Menunggu Pembayaran" {{ $p->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Bayar</option>
                                            <option value="Diproses" {{ $p->status_pesanan == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Selesai" {{ $p->status_pesanan == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Dibatalkan" {{ $p->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3">
                                            @if($p->status_pesanan == 'Dibatalkan') <i class="ph-bold ph-x-circle text-red-500 text-lg"></i>
                                            @elseif($p->berat == 0) <i class="ph-bold ph-lock-key text-slate-400 text-lg"></i>
                                            @elseif($p->status_pesanan == 'Selesai') <i class="ph-fill ph-check-circle text-emerald-500 text-lg"></i>
                                            @elseif($p->status_pesanan == 'Diproses') <i class="ph-bold ph-spinner text-brand-500 text-lg animate-spin"></i>
                                            @elseif($p->status_pesanan == 'Menunggu Pembayaran') <i class="ph-fill ph-warning-circle text-amber-500 text-lg"></i>
                                            @else <i class="ph-bold ph-hourglass text-slate-500 text-lg"></i> @endif
                                        </div>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <i class="ph-bold ph-caret-down"></i>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </td>

                        {{-- 6. AKSI (UPDATED) --}}
                        <td class="px-8 py-5 align-top text-right">
                            <div class="flex items-center justify-end gap-2 group-hover:opacity-100 transition-opacity {{ $p->berat == 0 ? 'opacity-100' : 'opacity-0' }}">
                                
                                {{-- TOMBOL REFUND (BARU) --}}
                                @if($p->jumlah_bayar > 0 && $p->status_pesanan != 'Dikembalikan' && $p->status_pesanan != 'Dibatalkan')
                                    <form action="{{ route('admin.pesanan.refund', $p->id_pesanan) }}" method="POST" id="form-refund-{{ $p->id_pesanan }}">
                                        @csrf
                                        <button type="button" 
                                            data-id="{{ $p->id_pesanan }}" 
                                            data-total="{{ number_format($p->jumlah_bayar, 0, ',', '.') }}"
                                            class="btn-refund w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 transition-all shadow-sm"
                                            title="Refund Manual & Batalkan">
                                            <i class="ph-bold ph-arrow-counter-clockwise text-lg"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- TOMBOL EDIT --}}
                                @if($p->status_pesanan != 'Dibatalkan' && $p->status_pesanan != 'Dikembalikan')
                                    <a href="/admin/pesanan/{{ $p->id_pesanan }}/edit" class="w-9 h-9 flex items-center justify-center rounded-lg border shadow-sm transition-all {{ $p->berat == 0 ? 'bg-brand-600 text-white border-brand-600 animate-bounce shadow-brand-200' : 'bg-white border-slate-200 text-slate-500 hover:bg-brand-500 hover:text-white' }}" title="{{ $p->berat == 0 ? 'Wajib: Input Berat' : 'Edit Pesanan' }}">
                                        <i class="ph-bold ph-pencil-simple text-lg"></i>
                                    </a>
                                @endif
                                
                                {{-- TOMBOL HAPUS --}}
                                <form action="/admin/pesanan/{{ $p->id_pesanan }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm" title="Hapus Permanen">
                                        <i class="ph-bold ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($pesanan->isEmpty())
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-inner">
                    <i class="ph-duotone ph-clipboard-text text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Tidak Ada Pesanan</h3>
                <p class="text-slate-500 font-medium text-sm">Belum ada data pesanan yang sesuai dengan filter Anda.</p>
            </div>
        @endif
    </div>

    {{-- MODAL PEMBAYARAN (TAILWIND STYLE) --}}
    <div id="paymentModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closePaymentModal()"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-6">
            <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden transform transition-all scale-100">
                
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Pembayaran Kasir</h3>
                        <p class="text-xs text-slate-500 font-medium">ID Pesanan: <span id="modalOrderId" class="font-bold text-brand-600">#000</span></p>
                    </div>
                    <button onclick="closePaymentModal()" class="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-colors">
                        <i class="ph-bold ph-x"></i>
                    </button>
                </div>

                <form id="paymentForm" method="POST" action="" class="p-6 space-y-5">
                    @csrf
                    
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2">
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Total Tagihan</span>
                            <span class="font-bold text-slate-800" id="modalTotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-emerald-600">
                            <span>Sudah Dibayar (DP)</span>
                            <span class="font-bold" id="modalSudahBayar">- Rp 0</span>
                        </div>
                        <div class="border-t border-slate-200 my-2"></div>
                        <div class="flex justify-between text-base">
                            <span class="font-bold text-rose-500">SISA TAGIHAN</span>
                            <span class="font-bold text-rose-600 text-lg" id="modalSisa">Rp 0</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Uang Diterima (Opsional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold">Rp</span>
                            </div>
                            <input type="number" name="uang_diterima" id="inputUang" 
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-slate-200 rounded-xl font-bold text-slate-800 focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-300" 
                                placeholder="0">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2 ml-1">Kosongkan jika uang pas. Isi nominal untuk hitung kembalian/DP.</p>
                    </div>

                    <div id="boxKembalian" class="hidden bg-emerald-50 rounded-xl p-3 border border-emerald-100 text-center">
                        <span class="text-xs font-bold text-emerald-600 block uppercase tracking-wider">Kembalian</span>
                        <span class="text-xl font-bold text-emerald-700" id="textKembalian">Rp 0</span>
                    </div>
                    
                    <div id="boxStatus" class="hidden bg-amber-50 rounded-xl p-3 border border-amber-100 text-center">
                        <span class="text-xs font-bold text-amber-600 block uppercase tracking-wider">Status Pembayaran</span>
                        <span class="text-sm font-bold text-amber-700" id="textStatus">Menjadi DP (Belum Lunas)</span>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg shadow-slate-200 hover:shadow-brand-200 flex items-center justify-center gap-2">
                        <i class="ph-bold ph-check-circle"></i>
                        <span>Proses Pembayaran</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    const modal = document.getElementById('paymentModal');
    const form = document.getElementById('paymentForm');
    const inputUang = document.getElementById('inputUang');
    let sisaTagihanGlobal = 0;

    function openPaymentModal(id, total, sudahBayar) {
        const sisa = total - sudahBayar;
        sisaTagihanGlobal = sisa;

        document.getElementById('modalOrderId').innerText = '#' + String(id).padStart(3, '0');
        document.getElementById('modalTotal').innerText = formatRupiah(total);
        document.getElementById('modalSudahBayar').innerText = '- ' + formatRupiah(sudahBayar);
        document.getElementById('modalSisa').innerText = formatRupiah(sisa);

        inputUang.value = ''; 
        document.getElementById('boxKembalian').classList.add('hidden');
        document.getElementById('boxStatus').classList.add('hidden');

        form.action = `/admin/pesanan/${id}/bayar-tunai`;

        modal.classList.remove('hidden');
        
        setTimeout(() => { inputUang.focus(); }, 100);
    }

    function closePaymentModal() {
        modal.classList.add('hidden');
    }

    inputUang.addEventListener('keyup', function() {
        const uangMasuk = parseInt(this.value) || 0;
        const boxKembalian = document.getElementById('boxKembalian');
        const boxStatus = document.getElementById('boxStatus');

        if(uangMasuk > 0) {
            if (uangMasuk >= sisaTagihanGlobal) {
                const kembalian = uangMasuk - sisaTagihanGlobal;
                document.getElementById('textKembalian').innerText = formatRupiah(kembalian);
                
                boxKembalian.classList.remove('hidden');
                boxStatus.classList.add('hidden');
            } else {
                const kurang = sisaTagihanGlobal - uangMasuk;
                document.getElementById('textStatus').innerText = `DP: Masih Kurang ${formatRupiah(kurang)}`;
                
                boxKembalian.classList.add('hidden');
                boxStatus.classList.remove('hidden');
            }
        } else {
            boxKembalian.classList.add('hidden');
            boxStatus.classList.add('hidden');
        }
    });

    form.addEventListener('submit', function() {
        closePaymentModal();
        showLoading();
    });

    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    document.querySelectorAll('.btn-refund').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const total = this.getAttribute('data-total');
            const formRefund = document.getElementById(`form-refund-${id}`);

            Swal.fire({
                title: 'Proses Refund?',
                html: `Anda akan mengubah status menjadi <b>Dikembalikan</b>.<br>Pastikan Anda sudah mentransfer manual <b>${total}</b> ke pelanggan.`, // Note: total disini string formatted
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d97706', 
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Saya Sudah Transfer',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#fff',
                customClass: { popup: 'rounded-[2rem] p-6', confirmButton: 'px-6 py-3 rounded-xl font-bold shadow-lg shadow-amber-200', cancelButton: 'px-6 py-3 rounded-xl font-bold' }
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    setTimeout(() => { formRefund.submit(); }, 800);
                }
            });
        });
    });


    function showLoading() {
        Swal.fire({
            title: '', icon: '', width: 400,
            html: `
                <div class="flex flex-col items-center justify-center pt-4">
                    <div class="relative w-20 h-20 mt-6 mb-6">
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-14 h-1.5 bg-slate-200 rounded-[100%] blur-sm animate-[pulse_1s_infinite]"></div>
                        <img src="{{ asset('img/logo.webp') }}" width="40" height="40" class="w-full h-full object-contain animate-bounce relative z-10" alt="Loading...">
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Memproses...</h3>
                    <p class="text-xs text-slate-500">Mohon tunggu sebentar.</p>
                </div>
            `,
            showConfirmButton: false, allowOutsideClick: false, allowEscapeKey: false, background: '#ffffff',
            customClass: { popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl !p-0 overflow-hidden' }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!', text: "{!! session('success') !!}", timer: 4000, showConfirmButton: false, background: '#ffffff',
            customClass: { popup: 'rounded-[2rem] p-6 shadow-xl border border-emerald-100', title: 'text-emerald-600 font-bold' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", customClass: { popup: 'rounded-[2rem] p-6' }
        });
    @endif
</script>
</div>
@endsection