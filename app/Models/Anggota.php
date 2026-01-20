<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Anggota extends Authenticatable
{
    use Notifiable;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'nama_anggota',
        'kelas',
        'jurusan',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
