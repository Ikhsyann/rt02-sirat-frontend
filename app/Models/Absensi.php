<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['kegiatan_id', 'anggota_keluarga_id', 'status_hadir'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class);
    }
}
