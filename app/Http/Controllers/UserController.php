<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        return view('user.dashboard'); 
    }

    public function layanan() {
        $layanan = Layanan::all(); 
        return view('user.layanan', compact('layanan'));
    }

    public function storePesanan(Request $request) {
        $request->validate([
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'metode' => 'required|in:Antar Jemput,Datang Sendiri',
        ]);

        $user = Auth::user();
        
        Pesanan::create([
            'id_pelanggan' => $user->id_pelanggan,
            'id_layanan' => $request->id_layanan,
            'berat' => 0,      
            'total_harga' => 0, 
            'status_pesanan' => 'Pending',
            'tanggal_pesan' => now(), 
            'metode' => $request->metode,
            'jumlah_bayar' => 0
        ]);

        return redirect('/riwayat')->with('success', 'Pesanan berhasil dibuat. Mohon tunggu konfirmasi admin/penjemputan.');
    }

    public function riwayat() {
        $pesanan = Pesanan::with('layanan')
            ->where('id_pelanggan', Auth::id())
            ->orderBy('id_pesanan', 'desc')
            ->get();
        return view('user.riwayat', compact('pesanan'));
    }

    public function cancelPesanan($id) {
        $pesanan = Pesanan::where('id_pelanggan', Auth::id())->findOrFail($id);

        if ($pesanan->status_pesanan !== 'Pending') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah ditimbang/diproses admin.');
        }

        $pesanan->delete();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function bayar($id) {
        $pesanan = Pesanan::with(['pelanggan', 'layanan'])->findOrFail($id);

        if ($pesanan->total_harga <= 0) {
             return response()->json(['error' => 'Pesanan sedang dihitung/ditimbang. Mohon tunggu notifikasi admin.'], 400);
        }

        $sisaTagihan = $pesanan->total_harga - $pesanan->jumlah_bayar;

        if ($sisaTagihan <= 0) {
            return response()->json(['error' => 'Pesanan ini sudah LUNAS.'], 400);
        }

        if ($pesanan->status_pesanan == 'Pending' || $pesanan->status_pesanan == 'Dibatalkan' || $pesanan->status_pesanan == 'Dikembalikan') {
             return response()->json(['error' => 'Status pesanan tidak valid untuk pembayaran.'], 400);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $custom_order_id = 'ORD-' . $pesanan->id_pesanan . '-' . time();

        $params = array(
            'transaction_details' => array(
                'order_id' => $custom_order_id,
                'gross_amount' => (int) $sisaTagihan,
            ),
            'customer_details' => array(
                'first_name' => $pesanan->pelanggan->nama,
                'phone' => $pesanan->pelanggan->no_hp,
            ),
            'item_details' => array(
                [
                    'id' => $pesanan->id_layanan,
                    'price' => (int) $sisaTagihan,
                    'quantity' => 1,
                    'name' => "Pelunasan Laundry #" . $pesanan->id_pesanan
                ]
            )
        );

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $pesanan->snap_token = $snapToken;
            $pesanan->save();
            
            return response()->json([
                'snapToken' => $snapToken,
                'order_id'  => $pesanan->id_pesanan
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess($id) {
        DB::transaction(function () use ($id) {
            $pesanan = Pesanan::lockForUpdate()->find($id);
            
            if($pesanan) {
                $pesanan->jumlah_bayar = $pesanan->total_harga;             
                if ($pesanan->status_pesanan == 'Menunggu Pembayaran') {
                    $pesanan->status_pesanan = 'Diproses';
                }
                
                $pesanan->save();
            }
        });

        return redirect('/riwayat')->with('success', 'Pembayaran Online Berhasil! Terima kasih.');
    }
}