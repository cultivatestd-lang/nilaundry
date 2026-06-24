<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    
    // MATIKAN TIMESTAMPS DISINI
    public $timestamps = false; 

    protected $fillable = ['nama', 'password', 'no_hp', 'alamat', 'progres_kg', 'bonus'];
    protected $hidden = ['password', 'remember_token'];
    
    
    public function pesanan() {
        return $this->hasMany(Pesanan::class, 'id_pelanggan');
    }
}