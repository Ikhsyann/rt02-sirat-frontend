<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
    }

    public function test_email_tidak_dapat_diubah_lewat_profil(): void
    {
        $user = User::factory()->create();

        // Email dikirim lewat PATCH tetapi tidak ada di rule validasi,
        // sehingga nilai di database harus tetap email lama.
        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => $user->name,
                'email' => 'email-baru@example.com',
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertSame($user->email, $user->fresh()->email);
    }

    public function test_akun_tidak_dapat_dihapus_sendiri(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile');

        // Route DELETE tidak terdaftar; jangan sampai akun bisa dihapus sendiri.
        $response->assertStatus(405);
        $this->assertNotNull($user->fresh());
        $this->assertNotNull(auth()->user());
    }
}
