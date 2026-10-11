<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    protected $fillable = ['nama_blok'];

    public function rumahs()
    {
        return $this->hasMany(Rumah::class);
    }
}
