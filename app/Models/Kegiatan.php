<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = ['nama_kegiatan', 'slug', 'tanggal', 'deskripsi', 'foto_dokumentasi'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function anggotaHadir()
    {
        return $this->belongsToMany(AnggotaKeluarga::class, 'absensis');
    }
}
