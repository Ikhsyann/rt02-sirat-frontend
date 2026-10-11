<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $fillable = ['blok_id', 'nomor_rumah'];

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }
}
