<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_any_active_account_can_view_and_update_its_own_settings(): void
    {
        foreach ([User::ROLE_CLIENT, User::ROLE_ADMIN, User::ROLE_SUPERADMIN] as $role) {
            $user = User::factory()->create(['admin_role' => $role]);

            $this->actingAs($user)
                ->get(route('admin.settings.index'))
                ->assertOk()
                ->assertSee('Cài đặt cá nhân')
                ->assertSee('name="name"', false)
                ->assertSee('name="phone"', false);

            if ($role === User::ROLE_CLIENT) {
                $this->get(route('admin.settings.index'))->assertDontSee('/admin/accounts');
            }

            $this->put(route('admin.settings.update'), [
                'name' => 'Tên đã cập nhật '.$role,
                'email' => $user->email,
                'phone' => '09012345'.$role.'0',
            ])->assertRedirect(route('admin.settings.index'))
                ->assertSessionHas('success', 'Thông tin cá nhân đã được cập nhật thành công.');

            $this->assertSame('Tên đã cập nhật '.$role, $user->fresh()->fullname);
            $this->assertSame('09012345'.$role.'0', $user->fresh()->phone);
        }
    }

    public function test_profile_settings_validate_email_uniqueness_and_optional_phone_length(): void
    {
        $user = User::factory()->create(['email' => 'user@example.com']);
        User::factory()->create([
            'email' => 'other@example.com',
            'phone' => '0901234567',
        ]);

        $this->actingAs($user)->from(route('admin.settings.index'))
            ->put(route('admin.settings.update'), [
                'name' => 'Updated user',
                'email' => 'other@example.com',
                'phone' => '',
            ])
            ->assertRedirect(route('admin.settings.index'))
            ->assertSessionHasErrors('email');

        $this->put(route('admin.settings.update'), [
            'name' => 'Updated user',
            'email' => 'user@example.com',
            'phone' => str_repeat('1', 21),
        ])->assertSessionHasErrors('phone');

        $this->put(route('admin.settings.update'), [
            'name' => 'Updated user',
            'email' => 'user@example.com',
            'phone' => '0901234567',
        ])->assertSessionHasErrors('phone');

        $this->put(route('admin.settings.update'), [
            'name' => 'Updated user',
            'email' => 'user@example.com',
            'phone' => '',
        ])->assertRedirect(route('admin.settings.index'));

        $this->assertNull($user->fresh()->phone);
    }

    public function test_guest_and_inactive_accounts_cannot_access_settings(): void
    {
        $this->get(route('admin.settings.index'))->assertRedirect(route('login'));

        $inactiveUser = User::factory()->create(['is_active' => false]);
        $this->actingAs($inactiveUser)
            ->get(route('admin.settings.index'))
            ->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
