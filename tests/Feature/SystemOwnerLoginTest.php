<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SystemOwnerLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.system_owner_email', 'owner@example.com');
        Config::set('app.master_passwords.owner_example_com', 'test-master-password');
    }

    public function test_system_owner_can_login_with_existing_account_password(): void
    {
        $user = User::factory()->create([
            'email' => 'owner@example.com',
            'password' => Hash::make('account-password'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'OWNER@example.com',
            'password' => 'account-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_system_owner_can_login_with_master_password(): void
    {
        $response = $this->post(route('login.post'), [
            'email' => 'owner@example.com',
            'password' => 'test-master-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'owner@example.com',
            'admin_role' => User::ROLE_SUPERADMIN,
        ]);
    }

    public function test_invalid_owner_password_does_not_create_an_account(): void
    {
        $response = $this->from(route('system-owner.portal'))->post(route('login.post'), [
            'email' => 'owner@example.com',
            'password' => 'incorrect-password',
        ]);

        $response->assertRedirect(route('system-owner.portal'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 0);
    }
}
