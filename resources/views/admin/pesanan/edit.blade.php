@extends('layouts.main')
@section('title', 'Edit Pesanan')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex items-center gap-4 mb-8">
        <a href="/admin/pesanan" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-brand-500 hover:text-white hover:border-brand-500 transition-all shadow-sm group">
            <i class="ph-bold ph-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Pesanan</h1>
            <div class="flex items-center gap-2 text-sm font-medium text-slate-500">
                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border border-slate-200 text-xs font-bold uppercase tracking-wider">
                    #{{ $pesanan->id_pesanan }}
                </span>
                <span>•</span>
                <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d F Y, H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        <div class="space-y-6">
            
            <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-8 border border-white/60 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-10">
                    <i class="ph-duotone ph-user text-6xl text-brand-600"></i>
                </div>
                
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Pelanggan</h3>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-100 to-fresh-100 flex items-center justify-center text-brand-600 font-bold text-2xl border border-white shadow-sm">
                        {{ substr($pesanan->pelanggan->nama, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xl font-bold text-slate-900">{{ $pesanan->pelanggan->nama }}</div>
                        <div class="text-sm text-slate-500 font-medium">{{ $pesanan->pelanggan->no_hp }}</div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="bg-white/50 p-4 rounded-2xl border border-white/60">
                        <div class="text-xs font-bold text-slate-400 uppercase mb-1">Alamat</div>
                        <div class="text-sm font-medium text-slate-700 leading-relaxed">{{ $pesanan->pelanggan->alamat }}</div>
                    </div>
                    <div class="bg-white/50 p-4 rounded-2xl border border-white/60 flex justify-between items-center">
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase mb-1">Metode</div>
                            <div class="text-sm font-bold text-slate-700">{{ $pesanan->metode }}</div>
                        </div>
                        <i class="ph-duotone {{ $pesanan->metode == 'Antar Jemput' ? 'ph-moped' : 'ph-storefront' }} text-2xl text-brand-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-8 border border-white/60 shadow-sm">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Detail Layanan</h3>
                
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-lg font-bold text-slate-900">{{ $pesanan->layanan->nama_layanan }}</div>
                        <div class="text-sm text-slate-500 font-medium">{{ $pesanan->layanan->jenis }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-bold text-slate-400 uppercase">Harga Dasar</div>
                        <div class="text-brand-600 font-bold">Rp {{ number_format($pesanan->layanan->harga, 0) }}<span class="text-xs text-slate-400">/kg</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] shadow-glass border border-slate-100 p-8 md:p-10 relative">
                
                <div class="absolute top-10 right-10 w-32 h-32 bg-brand-50 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold shadow-lg">
                        <i class="ph-bold ph-pencil-simple"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-xl text-slate-900">Update Data</h2>
                        <p class="text-xs text-slate-500 font-medium">Ubah status, berat, dan total harga.</p>
                    </div>
                </div>

                <form action="/admin/pesanan/{{ $pesanan->id_pesanan }}" method="POST" class="space-y-6 relative z-10">
                    @csrf 
                    @method('PUT')

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Status Pengerjaan</label>
                        <div class="relative">
                            <select name="status_pesanan" class="w-full appearance-none bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 outline-none transition-all font-bold cursor-pointer hover:border-brand-200">
                                <option value="Pending" {{ $pesanan->status_pesanan == 'Pending' ? 'selected' : '' }}>⏳ Pending </option>
                                <option value="Menunggu Pembayaran" {{ $pesanan->status_pesanan == 'Menunggu Pembayaran' ? 'selected' : '' }}>💳 Menunggu Pembayaran</option>
                                <option value="Diproses" {{ $pesanan->status_pesanan == 'Diproses' ? 'selected' : '' }}>🫧 Diproses </option>
                                <option value="Selesai" {{ $pesanan->status_pesanan == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 pointer-events-none">
                                <i class="ph-bold ph-caret-down text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Berat (Kg)</label>
                            <div class="relative group">
                                <input type="number" step="0.01" name="berat" id="inputBerat" value="{{ $pesanan->berat }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-lg rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold group-hover:border-slate-200"
                                       oninput="hitungTotal()" onkeyup="hitungTotal()">
                                <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                                    <i class="ph-bold ph-scales text-xl"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 ml-1">*Masukkan berat hasil timbangan.</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Total Tagihan (Rp)</label>
                            <div class="relative group">
                                <input type="number" name="total_harga" id="inputTotal" value="{{ $pesanan->total_harga }}"
                                       class="w-full bg-slate-100 border-2 border-slate-100 text-slate-900 text-lg rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all font-bold group-hover:border-slate-200"
                                       readonly> <div class="absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                                    <span class="text-lg font-bold">Rp</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 ml-1">*Terhitung otomatis (Berat x Harga).</p>
                        </div>
                    </div>

                    <div class="space-y-2 pt-4 border-t border-slate-50">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jumlah Terbayar (Rp)</label>
                        <div class="relative group">
                            <input type="number" name="jumlah_bayar" value="{{ $pesanan->jumlah_bayar ?? 0 }}"
                                   class="w-full bg-emerald-50 border-2 border-emerald-100 text-emerald-800 text-sm rounded-2xl focus:bg-white focus:border-emerald-500 block p-4 pl-12 outline-none transition-all font-bold">
                            <div class="absolute inset-y-0 left-0 flex items-center px-4 text-emerald-500">
                                <i class="ph-bold ph-money text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <a href="/admin/pesanan" class="w-full py-4 rounded-2xl border-2 border-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:text-slate-800 transition-all text-center">
                            Batal
                        </a>
                        <button type="submit" class="w-full py-4 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-brand-600 transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Simpan Perubahan</span>
                            <i class="ph-bold ph-check"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
    const hargaPerKg = {{ $pesanan->layanan->harga }};
    const progresLama = {{ $pesanan->user->progres_kg ?? 0 }};

    function hitungTotal() {
        const beratInputRaw = document.getElementById('inputBerat').value;
        const totalInput = document.getElementById('inputTotal');
        
        let beratInput = parseFloat(beratInputRaw) || 0;
        
        let totalAkumulasi = progresLama + beratInput;

        let jumlahGratis = Math.floor(totalAkumulasi / 9);

        let potonganSaatIni = 0;
        if (jumlahGratis > 0) {
            potonganSaatIni = Math.min(jumlahGratis, beratInput);
        }

        let beratTagihan = beratInput - potonganSaatIni;
        let totalBayar = beratTagihan * hargaPerKg;
        
        totalInput.value = Math.round(totalBayar);
    }
</script>
@endsection