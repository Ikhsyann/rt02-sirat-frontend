<?php

namespace App\Support;

final class LikePattern
{
    /**
     * Pola LIKE yang memperlakukan %, _ dan ! sebagai teks biasa.
     * Pemakaian: WHERE kolom LIKE ? ESCAPE '!'
     */
    public static function contains(string $text): string
    {
        return '%'.str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $text).'%';
    }
}
