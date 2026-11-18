<?php

namespace Tests\Feature;

use App\Models\InventoryTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.system_owner_email', 'owner@example.com');
    }

    public function test_regular_admin_can_manage_accounts_but_cannot_grant_admin_access(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $this->assertTrue($admin->is_active);
        $this->actingAs($admin);

        $this->get(route('admin.accounts.index'))->assertOk();
        $clientAccount = User::factory()->create(['admin_role' => User::ROLE_CLIENT]);
        $this->get(route('admin.accounts.edit', $clientAccount))->assertOk();

        $this->post(route('admin.accounts.store'), $this->accountData([
            'email' => 'employee@example.com',
        ]))->assertRedirect(route('admin.accounts.index'));

        $this->assertDatabaseHas('users', ['email' => 'employee@example.com', 'admin_role' => User::ROLE_CLIENT]);
        $this->assertTrue(Hash::check('new-password', User::where('email', 'employee@example.com')->value('password')));

        $this->post(route('admin.accounts.store'), $this->accountData([
            'email' => 'EMPLOYEE@example.com',
        ]))->assertSessionHasErrors('email');

        $this->post(route('admin.accounts.store'), $this->accountData([
            'email' => 'escalation@example.com',
            'admin_role' => User::ROLE_ADMIN,
        ]))->assertSessionHasErrors('admin_role');

        $this->assertDatabaseMissing('users', ['email' => 'escalation@example.com']);
    }

    public function test_system_owner_can_create_admin_accounts_but_cannot_manage_owner_accounts(): void
    {
        $owner = User::factory()->create([
            'email' => 'owner@example.com',
            'admin_role' => User::ROLE_SUPERADMIN,
        ]);
        $this->actingAs($owner);

        $this->post(route('admin.accounts.store'), $this->accountData([
            'email' => 'warehouse@example.com',
            'admin_role' => User::ROLE_ADMIN,
        ]))->assertRedirect(route('admin.accounts.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'warehouse@example.com',
            'admin_role' => User::ROLE_ADMIN,
        ]);

        $this->get(route('admin.accounts.edit', $owner))->assertForbidden();
        $this->delete(route('admin.accounts.destroy', $owner))->assertForbidden();
    }

    public function test_account_can_be_deactivated_and_then_cannot_login_or_use_admin_pages(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $account = User::factory()->create(['admin_role' => User::ROLE_CLIENT]);

        $this->actingAs($admin)->put(route('admin.accounts.update', $account), [
            'fullname' => $account->fullname,
            'email' => $account->email,
            'phone' => $account->phone,
            'admin_role' => User::ROLE_CLIENT,
            'is_active' => 0,
            'password' => '',
            'password_confirmation' => '',
        ])->assertRedirect(route('admin.accounts.index'));

        $this->assertFalse($account->fresh()->is_active);

        auth()->logout();
        $this->post(route('login.post'), [
            'email' => $account->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        $inactiveAdmin = User::factory()->create([
            'admin_role' => User::ROLE_ADMIN,
            'is_active' => false,
        ]);
        $this->actingAs($inactiveAdmin)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_account_with_inventory_history_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['admin_role' => User::ROLE_ADMIN]);
        $account = User::factory()->create(['admin_role' => User::ROLE_CLIENT]);
        InventoryTransaction::create([
            'transaction_code' => 'PN-ACCOUNT0001',
            'type' => InventoryTransaction::TYPE_IMPORT,
            'project_or_supplier_name' => 'Nhà cung cấp',
            'user_id' => $account->id,
            'transaction_date' => now(),
            'status' => 'completed',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.accounts.index'))
            ->delete(route('admin.accounts.destroy', $account))
            ->assertRedirect(route('admin.accounts.index'))
            ->assertSessionHasErrors('account');

        $this->assertDatabaseHas('users', ['id' => $account->id]);
    }

    public function test_regular_users_cannot_open_account_management(): void
    {
        $client = User::factory()->create(['admin_role' => User::ROLE_CLIENT]);

        $this->actingAs($client)
            ->get(route('admin.accounts.index'))
            ->assertForbidden();
    }

    private function accountData(array $overrides = []): array
    {
        return array_merge([
            'fullname' => 'Nhân viên kiểm thử',
            'email' => 'new-user@example.com',
            'phone' => '',
            'admin_role' => User::ROLE_CLIENT,
            'is_active' => 1,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ], $overrides);
    }
}
