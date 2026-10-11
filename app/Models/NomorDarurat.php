<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorDarurat extends Model
{
    protected $fillable = ['unit_darurat_id', 'lokasi', 'nomor_telepon'];

    public function unitDarurat()
    {
        return $this->belongsTo(UnitDarurat::class);
    }
}
