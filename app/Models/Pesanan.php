<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan', 'id_layanan', 'berat', 'total_harga', 
        'status_pesanan', 'tanggal_pesan', 'metode', 'jumlah_bayar'
    ];

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}