<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    // MATIKAN TIMESTAMPS
    public $timestamps = false;

    protected $fillable = ['username', 'password'];
    protected $hidden = ['password'];
}