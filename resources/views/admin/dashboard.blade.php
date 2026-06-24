{{-- Pastikan extends ini mengarah ke file main.blade.php kamu --}}
@extends('layouts.main') 

@section('title', 'Dashboard Admin')

@section('content')

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4" data-aos="fade-down">
        <div>
            <span class="text-brand-600 font-bold tracking-wider uppercase text-xs mb-1 block">Overview</span>
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800">Dashboard Keuangan</h1>
            <p class="text-slate-500 mt-2">Ringkasan performa bisnis dan operasional hari ini.</p>
        </div>
        <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">
            <div class="p-2 bg-brand-50 rounded-lg text-brand-600">
                <i class="ph-fill ph-calendar-blank text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">Tanggal</p>
                <p class="text-sm font-bold text-slate-700">{{ date('d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- ROW 1: KARTU STATISTIK (4 KOLOM) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-glow hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="0">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-fresh-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-fresh-100 text-fresh-500 flex items-center justify-center text-2xl mb-4 group-hover:bg-fresh-500 group-hover:text-white transition-colors">
                    <i class="ph-bold ph-trend-up"></i>
                </div>
                <p class="text-slate-500 text-sm font-semibold mb-1">Pemasukan Hari Ini</p>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($pemasukan_hari_ini, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-glow hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-brand-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center text-2xl mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="ph-bold ph-coins"></i>
                </div>
                <p class="text-slate-500 text-sm font-semibold mb-1">Omset Bulan Ini</p>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($pemasukan_bulan_ini, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-rose-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-500 flex items-center justify-center text-2xl mb-4 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                    <i class="ph-bold ph-warning-circle"></i>
                </div>
                <p class="text-slate-500 text-sm font-semibold mb-1">Piutang (Belum Lunas)</p>
                <h3 class="text-2xl font-bold text-rose-600">Rp {{ number_format($piutang, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-slate-50 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center text-2xl mb-4 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                    <i class="ph-bold ph-users"></i>
                </div>
                <p class="text-slate-500 text-sm font-semibold mb-1">Total Member</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $total_pelanggan }} <span class="text-sm font-normal text-slate-400">Orang</span></h3>
            </div>
        </div>
    </div>

    {{-- ROW 2: GRAFIK & OPERASIONAL --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 md:p-8 rounded-[2.5rem] shadow-sm border border-slate-100 lg:col-span-2 relative overflow-hidden" data-aos="fade-up" data-aos-delay="400">
    
            {{-- Header Grafik --}}
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 gap-6">
                
                {{-- Judul --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-6 rounded-full bg-brand-500"></span>
                        <h3 class="font-bold text-slate-800 text-xl tracking-tight">{{ $chart_title }}</h3>
                    </div>
                    <p class="text-sm text-slate-400 font-medium pl-3.5">Analisis performa pendapatan secara visual.</p>
                </div>
                
                {{-- Controls (Filter & Export) --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto">
                    
                    {{-- 1. TOMBOL EXCEL (Minimalis Aesthetic) --}}
                    <a href="{{ route('admin.laporan.export', ['filter' => $current_filter]) }}" 
                    class="group relative flex items-center gap-2.5 px-5 py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 transition-all duration-300 hover:border-emerald-400 hover:text-emerald-600 hover:shadow-[0_4px_20px_-4px_rgba(16,185,129,0.3)] w-full sm:w-auto justify-center">
                        
                        {{-- Indikator Dot Hijau --}}
                        <span class="absolute left-4 w-1.5 h-1.5 rounded-full bg-emerald-400 opacity-0 scale-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300"></span>
                        
                        <span class="group-hover:translate-x-2 transition-transform duration-300 flex items-center gap-2">
                            <i class="ph-bold ph-file-xls text-lg"></i>
                            <span>Export</span>
                        </span>
                    </a>

                    {{-- 2. SEGMENTED CONTROL (Filter Mingguan/Bulanan/Tahunan) --}}
                    <div class="flex p-1.5 bg-slate-50/80 backdrop-blur-sm rounded-full border border-slate-100 w-full sm:w-auto">
                        
                        {{-- Item: Mingguan --}}
                        <a href="?filter=mingguan" 
                        class="relative flex-1 sm:flex-none px-4 py-2 rounded-full text-[11px] font-bold uppercase tracking-wider text-center transition-all duration-300 {{ $current_filter == 'mingguan' ? 'bg-white text-brand-600 shadow-sm shadow-slate-200/50' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-100/50' }}">
                        Minggu
                        </a>

                        {{-- Item: Bulanan --}}
                        <a href="?filter=bulanan" 
                        class="relative flex-1 sm:flex-none px-4 py-2 rounded-full text-[11px] font-bold uppercase tracking-wider text-center transition-all duration-300 {{ $current_filter == 'bulanan' ? 'bg-white text-brand-600 shadow-sm shadow-slate-200/50' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-100/50' }}">
                        Bulan
                        </a>

                        {{-- Item: Tahunan --}}
                        <a href="?filter=tahunan" 
                        class="relative flex-1 sm:flex-none px-4 py-2 rounded-full text-[11px] font-bold uppercase tracking-wider text-center transition-all duration-300 {{ $current_filter == 'tahunan' ? 'bg-white text-brand-600 shadow-sm shadow-slate-200/50' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-100/50' }}">
                        Tahun
                        </a>

                    </div>
                </div>
            </div>
            
            {{-- Canvas Grafik --}}
            <div class="h-80 w-full relative z-10">
                <canvas id="incomeChart"></canvas>
            </div>

            {{-- Dekorasi Background Abstrak (Opsional, agar tidak terlalu polos) --}}
            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-white via-white/50 to-transparent pointer-events-none"></div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-glow text-slate-600 flex flex-col justify-between relative overflow-hidden" data-aos="fade-up" data-aos-delay="500">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full opacity-20 blur-[80px] -translate-y-10 translate-x-10 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-fresh-400 rounded-full opacity-20 blur-[60px] translate-y-10 -translate-x-10 pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div>
                        <h3 class="font-bold text-slate-800 leading-tight">Status Cucian</h3>
                        <p class="text-slate-400 text-xs">Real-time update</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors cursor-default">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.5)] animate-pulse"></span>
                            <span class="text-sm font-medium text-slate-800">Menunggu Pembayaran</span>
                        </div>
                        <span class="text-lg font-bold">{{ $status_counts['baru'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors cursor-default">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                            <span class="text-sm font-medium text-slate-800">Sedang Diproses</span>
                        </div>
                        <span class="text-lg font-bold">{{ $status_counts['proses'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition-colors cursor-default">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                            <span class="text-sm font-medium text-slate-800">Siap Diambil</span>
                        </div>
                        <span class="text-lg font-bold">{{ $status_counts['siap'] }}</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-8">
                <a href="{{ url('/admin/pesanan') }}" class="block w-full py-3.5 bg-brand-600 hover:bg-brand-500 text-white rounded-xl font-bold text-center transition-all shadow-lg hover:shadow-brand-500/30 text-sm">
                    Kelola Semua Pesanan <i class="ph-bold ph-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- ROW 3: TABEL TRANSAKSI --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden" data-aos="fade-up" data-aos-delay="600">
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Transaksi Selesai Terakhir</h3>
                <p class="text-sm text-slate-400">10 Data pesanan yang sudah selesai dan lunas.</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50/50 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="px-6 md:px-8 py-4">ID Pesanan</th>
                        <th class="px-6 md:px-8 py-4">Pelanggan</th>
                        <th class="px-6 md:px-8 py-4">Layanan</th>
                        <th class="px-6 md:px-8 py-4">Total & Berat</th>
                        <th class="px-6 md:px-8 py-4 text-right">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pesanan_terbaru as $p)
                    <tr class="hover:bg-brand-50/30 transition-colors group">
                        <td class="px-6 md:px-8 py-4 font-bold text-brand-600">
                            #{{ $p->id_pesanan }}
                        </td>
                        <td class="px-6 md:px-8 py-4">
                            <div class="font-bold text-slate-800">{{ $p->pelanggan->nama }}</div>
                            <div class="text-xs text-slate-400">{{ $p->pelanggan->no_hp }}</div>
                        </td>
                        <td class="px-6 md:px-8 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-xs font-semibold text-slate-600">
                                {{ $p->layanan->nama_layanan }}
                            </span>
                        </td>
                        <td class="px-6 md:px-8 py-4">
                            <div class="font-bold text-slate-800">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500">{{ $p->berat }} {{ $p->layanan->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}</div>
                        </td>
                        <td class="px-6 md:px-8 py-4 text-right text-slate-500">
                           <div class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">
                            Belum ada riwayat transaksi selesai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- CHART SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('incomeChart').getContext('2d');
            
            // Gradient Fill
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)'); // Brand Blue opacity
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart_label) !!},
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($chart_data) !!},
                        borderWidth: 3,
                        borderColor: '#2563eb', // Brand-600
                        backgroundColor: gradient,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 13, family: "'Outfit', sans-serif" },
                            bodyFont: { size: 13, family: "'Outfit', sans-serif" },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#f1f5f9' },
                            ticks: {
                                font: { family: "'Outfit', sans-serif", size: 11 },
                                color: '#94a3b8',
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: "'Outfit', sans-serif", size: 11 },
                                color: '#94a3b8'
                            },
                            border: { display: false }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>

@endsection