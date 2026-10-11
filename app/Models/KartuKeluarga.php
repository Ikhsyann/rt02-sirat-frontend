<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $fillable = ['rumah_id', 'nomor_kk', 'foto_kk'];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function anggotaKeluargas()
    {
        return $this->hasMany(AnggotaKeluarga::class);
    }
}
