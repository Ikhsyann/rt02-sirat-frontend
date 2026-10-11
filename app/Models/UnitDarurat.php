<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitDarurat extends Model
{
    protected $fillable = ['nama_unit'];

    public function nomorDarurats()
    {
        return $this->hasMany(NomorDarurat::class);
    }
}
