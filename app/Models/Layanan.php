<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';

    // MATIKAN TIMESTAMPS
    public $timestamps = false;

    protected $fillable = ['id_admin', 'nama_layanan', 'harga', 'jenis'];
}