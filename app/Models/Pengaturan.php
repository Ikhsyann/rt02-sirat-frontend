<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Read-only mirror tabel `pengaturans` milik repo Backend (satu baris, id=1).
 * Tidak ada migrasi di repo ini; tabel hilang/DB kosong cukup menghasilkan null.
 */
class Pengaturan extends Model
{
    protected $fillable = ['hero_media'];

    private const VIDEO_EXT = ['mp4', 'webm', 'ogv', 'mov'];

    public static function current(): ?self
    {
        try {
            return static::query()->find(1);
        } catch (\Throwable) {
            return null;
        }
    }

    public function heroUrl(): ?string
    {
        return $this->hero_media ? asset('storage/'.$this->hero_media) : null;
    }

    public function heroIsVideo(): bool
    {
        return in_array(strtolower(pathinfo((string) $this->hero_media, PATHINFO_EXTENSION)), self::VIDEO_EXT, true);
    }
}
