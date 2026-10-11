<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    protected $fillable = [
        'kartu_keluarga_id', 'user_id', 'nama', 'nik', 'tempat_lahir',
        'tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'golongan_darah',
        'status_perkawinan', 'tanggal_perkawinan_perceraian', 'status_hubungan_keluarga',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_perkawinan_perceraian' => 'date',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
