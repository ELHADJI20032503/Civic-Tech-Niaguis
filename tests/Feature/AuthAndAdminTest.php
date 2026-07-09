<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthAndAdminTest extends TestCase
{
    use WithFaker;

    public function test_login_fails_when_user_does_not_exist(): void
    {
        $response = $this->post(route('login.post'), [
            'login' => 'inconnu@niaguis.sn',
            'password' => 'motdepasse',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('login');
    }

    public function test_login_succeeds_for_existing_user(): void
    {
        DB::table('utilisateurs')->insert([
            'login' => 'agent@niaguis.sn',
            'password_hash' => Hash::make('Secret123!'),
            'prenom' => 'Aminata',
            'nom' => 'Sarr',
            'role' => 'relais',
            'statut_compte' => 'actif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('login.post'), [
            'login' => 'agent@niaguis.sn',
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('relais.dashboard'));
        $this->assertTrue(session()->has('auth_user_id'));
        $this->assertSame('Aminata Sarr', session('user_fullname'));
    }

    public function test_admin_can_create_agent_with_valid_data(): void
    {
        $response = $this->withSession([
            'auth_user_id' => 1,
            'active_profile' => 'admin',
        ])->post(route('admin.agents.store'), [
            'prenom' => 'Moussa',
            'nom' => 'Baldé',
            'login' => 'moussa.balde@niaguis.sn',
            'role' => 'relais',
            'password' => 'Password!123',
        ]);

        $response->assertRedirect(route('admin.agents'));
        $this->assertDatabaseHas('utilisateurs', [
            'login' => 'moussa.balde@niaguis.sn',
            'prenom' => 'Moussa',
            'nom' => 'Baldé',
            'role' => 'relais',
        ]);

        $row = DB::table('utilisateurs')->where('login', 'moussa.balde@niaguis.sn')->first();
        $this->assertNotNull($row);
        $this->assertTrue(Hash::check('Password!123', $row->password_hash));
    }

    public function test_admin_agents_page_is_accessible(): void
    {
        $response = $this->withSession([
            'auth_user_id' => 1,
            'active_profile' => 'admin',
        ])->get(route('admin.agents'));

        $response->assertStatus(200);
        $response->assertSee('Gestion des Comptes Professionnels');
    }

    public function test_unauthenticated_user_cannot_access_admin_routes(): void
    {
        $response = $this->get(route('admin.agents'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('login');
    }

    public function test_admin_cannot_create_agent_with_short_password(): void
    {
        $response = $this->withSession([
            'auth_user_id' => 1,
            'active_profile' => 'admin',
        ])->post(route('admin.agents.store'), [
            'prenom' => 'Moussa',
            'nom' => 'Baldé',
            'login' => 'moussa.balde@niaguis.sn',
            'role' => 'relais',
            'password' => '123',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('utilisateurs', [
            'login' => 'moussa.balde@niaguis.sn',
        ]);
    }
}
