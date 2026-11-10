<?php

namespace Tests\Feature;

use App\Models\Pengaturan;
use Tests\TestCase;

/** Komponen hero dipakai beranda publik dan portal warga; satu sumber media. */
class HeroMediaTest extends TestCase
{
    public function test_tanpa_pengaturan_memakai_gambar_cadangan(): void
    {
        $this->blade('<x-hero-media :media="null" fallback="images/hero-beranda.jpg" />')
            ->assertSee('images/hero-beranda.jpg', false);
    }

    public function test_media_gambar_dari_admin_dipakai(): void
    {
        $this->blade('<x-hero-media :media="$media" fallback="images/hero-portal.jpg" />', [
            'media' => new Pengaturan(['hero_media' => 'hero/hero.png']),
        ])
            ->assertSee('/storage/hero/hero.png', false)
            ->assertDontSee('hero-portal.jpg');
    }

    public function test_media_video_dirender_sebagai_video(): void
    {
        $this->blade('<x-hero-media :media="$media" fallback="images/hero-beranda.jpg" />', [
            'media' => new Pengaturan(['hero_media' => 'hero/hero.mp4']),
        ])
            ->assertSee('<video', false)
            ->assertSee('/storage/hero/hero.mp4', false);
    }
}
