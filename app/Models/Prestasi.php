<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = [
        'judul', 'jenis', 'tanggal', 'deskripsi', 'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
