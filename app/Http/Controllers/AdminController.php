<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganNiLaundry;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
    $pemasukan_hari_ini = Pesanan::whereDate('tanggal_pesan', Carbon::today())
        ->sum('jumlah_bayar'); 

    $pemasukan_bulan_ini = Pesanan::whereMonth('tanggal_pesan', Carbon::now()->month)
        ->whereYear('tanggal_pesan', Carbon::now()->year)
        ->sum('jumlah_bayar');

    $piutang = Pesanan::whereColumn('total_harga', '>', 'jumlah_bayar')
        ->where('status_pesanan', '!=', 'Dibatalkan')
        ->sum(DB::raw('total_harga - jumlah_bayar'));

    $status_counts = [
        'baru' => Pesanan::where('status_pesanan', 'Menunggu Pembayaran')->count(),
        'proses' => Pesanan::where('status_pesanan', 'Diproses')->count(),
        'siap' => Pesanan::where('status_pesanan', 'Selesai')->count(), 
    ];

    $filter = $request->input('filter', 'mingguan');
    $chart_data = [];
    $chart_label = [];
    $chart_title = '';

    if ($filter == 'bulanan') {
        $chart_title = 'Pemasukan Tahun ' . date('Y');
        
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create(null, $i, 1);
            $chart_label[] = $date->format('F'); 
            
            $income = Pesanan::whereYear('tanggal_pesan', Carbon::now()->year)
                ->whereMonth('tanggal_pesan', $i)
                ->sum('jumlah_bayar');
                
            $chart_data[] = $income;
        }

    } elseif ($filter == 'tahunan') {
        $chart_title = 'Pemasukan 5 Tahun Terakhir';
        
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $chart_label[] = $year;
            
            $income = Pesanan::whereYear('tanggal_pesan', $year)
                ->sum('jumlah_bayar');
                
            $chart_data[] = $income;
        }

    } else {
        $chart_title = 'Pemasukan 7 Hari Terakhir';
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chart_label[] = $date->format('d M');
            
            $income = Pesanan::whereDate('tanggal_pesan', $date)
                ->sum('jumlah_bayar');
                
            $chart_data[] = $income;
        }
    }

    $pesanan_terbaru = Pesanan::with(['pelanggan', 'layanan'])
        ->where('status_pesanan', 'Selesai')
        ->whereColumn('jumlah_bayar', '>=', 'total_harga')
        ->orderBy('id_pesanan', 'desc')
        ->take(5)
        ->get();

    $data = [
        'total_pelanggan' => Pelanggan::count(),
        'pemasukan_hari_ini' => $pemasukan_hari_ini,
        'pemasukan_bulan_ini' => $pemasukan_bulan_ini,
        'piutang' => $piutang,
        'status_counts' => $status_counts,
        
        'chart_label' => $chart_label, 
        'chart_data' => $chart_data,
        'chart_title' => $chart_title, 
        'current_filter' => $filter,   
        
        'pesanan_terbaru' => $pesanan_terbaru
    ];

    return view('admin.dashboard', $data);
}

    public function updateStatus(Request $request, $id) {
    $pesanan = Pesanan::with(['layanan', 'pelanggan'])->findOrFail($id);
    
    $status_lama = $pesanan->status_pesanan;
    $pesanan->status_pesanan = $request->status_pesanan;
    $pesanan->save();

    if ($request->status_pesanan == 'Selesai' && $status_lama != 'Selesai') {
        
        $pelanggan = $pesanan->pelanggan; 
        
        if ($pelanggan && $pesanan->layanan) {
            
            $harga_per_kg = $pesanan->layanan->harga;
            $berat_poin = 0;

            if ($harga_per_kg > 0) {
                $berat_poin = $pesanan->total_harga / $harga_per_kg;
            }

            $pelanggan->progres_kg += $berat_poin;

            while ($pelanggan->progres_kg >= 8) {
                $pelanggan->increment('bonus'); 
                $pelanggan->progres_kg -= 8;    
            }
            
            $pelanggan->save();

            try {
                    $sudahBayar = $pesanan->jumlah_bayar;
                    $totalTagihan = $pesanan->total_harga;
                    $sisaTagihan = $totalTagihan - $sudahBayar;
                    
                    $isLunas = $sisaTagihan <= 0;

                    $pesanWA = "Halo Kak *{$pelanggan->nama}*!\n\n";
                    $pesanWA .= "Update status pesanan *#{$pesanan->id_pesanan}*:\n";
                    $pesanWA .= "Status: *SELESAI*\n\n";
                    
                    $satuan = ($pesanan->layanan->jenis == 'Kiloan') ? 'Kg' : 'Pcs';
                    $pesanWA .= "Total Berat/Jml: {$pesanan->berat} {$satuan}\n";

                    if ($isLunas) {
                        $pesanWA .= "Status Bayar: *LUNAS*\n\n";
                        $pesanWA .= "Cucian Anda sudah bersih dan wangi. Silakan diambil di outlet kami atau hubungi admin untuk pengantaran.\n\n";
                    } else {
                        $pesanWA .= "Total Tagihan: Rp " . number_format($totalTagihan, 0, ',', '.') . "\n";
                        $pesanWA .= "Sudah Dibayar: Rp " . number_format($sudahBayar, 0, ',', '.') . "\n";
                        $pesanWA .= "Kekurangan: *Rp " . number_format($sisaTagihan, 0, ',', '.') . "*\n\n";
                        
                        $pesanWA .= "Cucian sudah siap! Mohon selesaikan pembayaran saat pengambilan, atau klik link di bawah ini untuk pembayaran online:\n";
                        $pesanWA .= url('/pesanan') . " \n\n"; 
                    }

                    $pesanWA .= "----------------\n";
                    $pesanWA .= "Poin Loyalty Anda: {$pelanggan->progres_kg}/8 Poin\n";
                    $pesanWA .= "Terima kasih telah menggunakan Ni Laundry! ";

                    $this->sendWhatsapp($pelanggan->no_hp, $pesanWA);
                    
                } catch (\Exception $e) {
                    \Log::error("Gagal kirim WA pesanan selesai: " . $e->getMessage());
                }

        }
    }

    return back()->with('success', 'Status berhasil diubah menjadi Selesai.');
}


public function bayarTunai(Request $request, $id) {
    return DB::transaction(function() use ($request, $id) {
        $pesanan = Pesanan::with('pelanggan')->findOrFail($id);

        $totalTagihan = $pesanan->total_harga;
        $sudahBayar   = $pesanan->jumlah_bayar ?? 0; 
        $sisaTagihan  = $totalTagihan - $sudahBayar;

        if ($sisaTagihan <= 0) {
            return back()->with('error', 'Pesanan ini SUDAH LUNAS sepenuhnya.');
        }

        $uangDiterima = $request->filled('uang_diterima') ? $request->uang_diterima : $sisaTagihan;

        
        $nominalMasuk = 0;
        $kembalian = 0;
        $statusBayar = '';

        if ($uangDiterima >= $sisaTagihan) {
            $nominalMasuk = $sisaTagihan;
            $kembalian = $uangDiterima - $sisaTagihan;
            $statusBayar = 'LUNAS';
        } else {
            $nominalMasuk = $uangDiterima;
            $kembalian = 0;
            $statusBayar = 'DP / BELUM LUNAS';
        }

        $pesanan->jumlah_bayar += $nominalMasuk;

        if ($pesanan->status_pesanan == 'Menunggu Pembayaran' && $pesanan->jumlah_bayar > 0) {
            $pesanan->status_pesanan = 'Diproses';
        }

        $pesanan->save();

        try {
            if ($pesanan->pelanggan && $pesanan->pelanggan->no_hp) {
                $sisaBaru = $totalTagihan - $pesanan->jumlah_bayar;
                
                $pesanWA = "Halo Kak *{$pesanan->pelanggan->nama}*!\n\n";
                $pesanWA .= "Pembayaran TUNAI diterima untuk pesanan *#{$pesanan->id_pesanan}*.\n";
                $pesanWA .= "Nominal Masuk: Rp " . number_format($nominalMasuk, 0, ',', '.') . "\n";
                $pesanWA .= "Sisa Tagihan: Rp " . number_format($sisaBaru, 0, ',', '.') . "\n\n";
                
                if ($sisaBaru <= 0) {
                    $pesanWA .= "Status: *LUNAS*\n";
                    if ($pesanan->status_pesanan == 'Selesai') {
                        $pesanWA .= "Silakan ambil cucian Anda. Terima kasih!";
                    } else {
                        $pesanWA .= "Cucian sedang diproses.";
                    }
                } else {
                    $pesanWA .= "Status: *BELUM LUNAS (DP)*\n";
                    $pesanWA .= "Mohon lunasi saat pengambilan.";
                }

                $this->sendWhatsapp($pesanan->pelanggan->no_hp, $pesanWA);
            }
        } catch (\Exception $e) {
            \Log::error("Gagal kirim WA: " . $e->getMessage());
        }

        $msg = "Pembayaran Berhasil dicatat (Rp " . number_format($nominalMasuk) . ").";
        if ($kembalian > 0) {
            $msg .= " KEMBALIAN: Rp " . number_format($kembalian, 0, ',', '.');
        }
        if ($statusBayar == 'DP / BELUM LUNAS') {
            $msg .= " Masih kurang: Rp " . number_format($sisaTagihan - $nominalMasuk, 0, ',', '.');
        }

        return back()->with('success', $msg);
    });
}

    // CRUD LAYANAN
    
    public function layananIndex() {
        $layanan = Layanan::all();
        return view('admin.layanan.index', compact('layanan'));
    }

    public function layananCreate() {
        return view('admin.layanan.create');
    }

    public function layananStore(Request $request) {
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
            'jenis' => $request->jenis,
            'id_admin' => Auth::guard('admin')->id() 
        ]);
        return redirect('/admin/layanan')->with('success', 'Layanan berhasil ditambahkan');
    }

    public function layananEdit($id) {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function layananUpdate(Request $request, $id) {
        $layanan = Layanan::findOrFail($id);
        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
            'jenis' => $request->jenis
        ]);
        return redirect('/admin/layanan')->with('success', 'Layanan berhasil diupdate');
    }

    public function layananDestroy($id) {
        Layanan::findOrFail($id)->delete();
        return redirect('/admin/layanan')->with('success', 'Layanan dihapus');
    }

    // MANAJEMEN PESANAN

    public function pesananIndex(Request $request) {
        $query = Pesanan::with(['pelanggan', 'layanan']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                
                $q->whereHas('pelanggan', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', '%' . $search . '%');
                })
                ->orWhereHas('layanan', function($subQ) use ($search) {
                    $subQ->where('nama_layanan', 'like', '%' . $search . '%')
                         ->orWhere('jenis', 'like', '%' . $search . '%');
                })
                ->orWhere('status_pesanan', 'like', '%' . $search . '%')
                ->orWhere('id_pesanan', 'like', '%' . $search . '%')
                ->orWhere('tanggal_pesan', 'like', '%' . $search . '%');
                
                $bulanIndo = [
                    'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                    'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                    'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
                ];

                foreach ($bulanIndo as $nama => $angka) {
                    if (stripos($nama, $search) !== false) {
                        $q->orWhereMonth('tanggal_pesan', $angka);
                    }
                }
            });
        }

        $pesanan = $query->orderBy('id_pesanan', 'desc')->get();

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function pesananEdit($id) {
       $pesanan = Pesanan::where('id_pesanan', $id)->firstOrFail();
        
        // dd($pesanan);
        return view('admin.pesanan.edit', compact('pesanan'));
    }

    public function pesananUpdate(Request $request, $id) {
    $pesanan = Pesanan::with('pelanggan')->findOrFail($id);
    
    $dataUpdate = [
        'berat' => $request->berat,
        'total_harga' => $request->total_harga, 
        'status_pesanan' => $request->status_pesanan,
    ];

    if ($request->filled('jumlah_bayar')) {
        $dataUpdate['jumlah_bayar'] = $request->jumlah_bayar;
    }

    $pesanan->update($dataUpdate);

        if ($request->status_pesanan == 'Menunggu Pembayaran') {
            try {
                $pelanggan = $pesanan->pelanggan;
                $pesanWA = "Halo Kak *{$pelanggan->nama}*! \n\n";
                $pesanWA .= "Cucian Anda (#{$pesanan->id_pesanan}) sudah kami timbang.\n";
                $pesanWA .= "Berat: *{$request->berat} Kg*\n";
                $pesanWA .= "Total Tagihan: *Rp " . number_format($request->total_harga, 0, ',', '.') . "*\n\n";
                $pesanWA .= "Silakan buka menu *Riwayat* di aplikasi/web untuk melakukan pembayaran agar cucian segera diproses. Terima kasih!";

                $this->sendWhatsapp($pelanggan->no_hp, $pesanWA);
            } catch (\Exception $e) {
            }
        }

        return redirect('/admin/pesanan')->with('success', 'Pesanan diperbarui. Notifikasi tagihan (jika ada) telah dikirim ke pelanggan.');
    }

    public function processRefund($id) {
        // Gunakan Transaction agar aman
        return DB::transaction(function() use ($id) {
            $pesanan = Pesanan::with(['pelanggan', 'layanan'])->findOrFail($id);

            // 1. VALIDASI: Cek apakah sudah bayar
            if ($pesanan->jumlah_bayar <= 0) {
                return back()->with('error', 'Pesanan ini belum dibayar, tidak ada dana yang bisa di-refund.');
            }

            // 2. VALIDASI LOGIKA BARU: Blokir jika sudah Selesai
            // Pesanan 'Selesai' dianggap final (barang sudah dibawa pulang).
            if ($pesanan->status_pesanan == 'Selesai') {
                return back()->with('error', 'GAGAL! Pesanan berstatus SELESAI tidak bisa di-refund. Transaksi dianggap final.');
            }

            // Simpan nominal untuk pesan WA
            $nominalRefund = $pesanan->jumlah_bayar;

            // --- Bagian tarik poin KITA HAPUS ---
            // Karena kita memblokir status 'Selesai', maka otomatis pesanan ini
            // belum pernah generate poin (poin hanya didapat saat status berubah ke Selesai).
            // Jadi tidak perlu logika pengurangan poin di sini.

            // 3. Update Data Pesanan
            $pesanan->jumlah_bayar = 0; 
            $pesanan->status_pesanan = 'Dikembalikan'; // atau 'Dibatalkan'
            $pesanan->save();

            // 4. Kirim Notifikasi WA Refund
            try {
                if ($pesanan->pelanggan) {
                    $pesanWA = "Halo Kak *{$pesanan->pelanggan->nama}*,\n\n";
                    $pesanWA .= "Pengembalian Dana (Refund) untuk pesanan *#{$pesanan->id_pesanan}* telah diproses.\n";
                    $pesanWA .= "Nominal Refund: *Rp " . number_format($nominalRefund, 0, ',', '.') . "*\n";
                    $pesanWA .= "Status Pesanan: *DIBATALKAN*\n\n";
                    $pesanWA .= "Dana telah dikembalikan. Mohon maaf atas ketidaknyamanannya. 🙏";

                    $this->sendWhatsapp($pesanan->pelanggan->no_hp, $pesanWA);
                }
            } catch (\Exception $e) {
                Log::error("Gagal kirim WA Refund: " . $e->getMessage());
            }

            return back()->with('success', 'Refund berhasil diproses. Status pesanan diubah menjadi Dikembalikan.');
        });
    }

    public function pesananDestroy($id) {
    $pesanan = Pesanan::with(['layanan', 'pelanggan'])->findOrFail($id);

    if ($pesanan->status_pesanan == 'Selesai') {
        
        $pelanggan = $pesanan->pelanggan;
        
        if ($pelanggan && $pesanan->layanan) {
            
            $harga_layanan = $pesanan->layanan->harga;
            
            $berat_poin_dihapus = ($harga_layanan > 0) 
                ? floor($pesanan->total_harga / $harga_layanan) 
                : 0;

            $pelanggan->progres_kg -= $berat_poin_dihapus;

            while ($pelanggan->progres_kg < 0) {
                if ($pelanggan->bonus > 0) {
                    $pelanggan->decrement('bonus'); 
                    $pelanggan->progres_kg += 8;    
                } else {
                    $pelanggan->progres_kg = 0;     
                    break; 
                }
            }
            
            $pelanggan->save();
        }
    }

    $pesanan->delete();

    if (Pesanan::count() == 0) {
        DB::statement('ALTER TABLE pesanan AUTO_INCREMENT = 1');
    }    
    
    return back()->with('success', 'Pesanan berhasil dihapus.');
}

    // CRUD ADMIN

    public function userAdminIndex() {
        $admins = Admin::all();
        return view('admin.users.index', compact('admins'));
    }

    public function userAdminCreate() {
        return view('admin.users.create');
    }

    public function userAdminStore(Request $request) {
        $request->validate([
            'username' => 'required|unique:admin,username',
            'password' => 'required|min:6'
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password) 
        ]);

        return redirect('/admin/users')->with('success', 'Admin baru berhasil ditambahkan');
    }

    public function userAdminEdit($id) {
        $admin = Admin::findOrFail($id);
        return view('admin.users.edit', compact('admin'));
    }

    public function userAdminUpdate(Request $request, $id) {
        $admin = Admin::findOrFail($id);

        $data = [
            'username' => $request->username
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect('/admin/users')->with('success', 'Data admin diperbarui');
    }

    public function userAdminDestroy($id) {
        if ($id == Auth::guard('admin')->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun yang sedang digunakan!');
        }

        Admin::findOrFail($id)->delete();
        return redirect('/admin/users')->with('success', 'Admin berhasil dihapus');
    }

    public function diskonIndex() {
        $pelanggan = Pelanggan::orderBy('bonus', 'desc')
                              ->orderBy('progres_kg', 'desc')
                              ->get();
                              
        return view('admin.diskon.index', compact('pelanggan'));
    }

    public function resetBonus($id) {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->bonus = 0; 
        $pelanggan->save();
        
        return back()->with('success', 'Bonus pelanggan berhasil di-reset manual.');
    }

    private function sendWhatsapp($nomor, $pesan) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $nomor,
            'message' => $pesan,
            'countryCode' => '62', 
          ),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Z4RJR27QU6JaxbXVAt2a' 
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }

    public function exportExcel(Request $request) 
    {
        $filter = $request->input('filter', 'mingguan');
        $namaFile = 'Laporan_Keuangan_' . ucfirst($filter) . '_' . date('d-m-Y') . '.xlsx';
        
        return Excel::download(new LaporanKeuanganNiLaundry($filter), $namaFile);
    }
}