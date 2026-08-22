<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_GUEST = 0;
    public const ROLE_CLIENT = 1;
    public const ROLE_ADMIN = 2;
    public const ROLE_SUPERADMIN = 3;

    protected $fillable = [
        'fullname',
        'avatar',
        'username',
        'password',
        'email',
        'phone',
        'google_id',
        'admin_role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'admin_role' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['fullname'] ?? null,
            set: fn (?string $value) => ['fullname' => $value],
        );
    }

    /**
     * Danh sách lịch hẹn của khách hàng này (khi đặt lịch lúc đã đăng nhập).
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isGuest(): bool
    {
        return (int) ($this->admin_role ?? self::ROLE_GUEST) === self::ROLE_GUEST;
    }

    public function isClient(): bool
    {
        return (int) ($this->admin_role ?? self::ROLE_GUEST) === self::ROLE_CLIENT;
    }

    public function isCustomer(): bool
    {
        return $this->isClient();
    }

    /**
     * Nhân viên/barber được cấp quyền quản trị, hoặc là System Owner (luôn có toàn quyền).
     */
    public function isAdmin(): bool
    {
        return (int) ($this->admin_role ?? self::ROLE_GUEST) === self::ROLE_ADMIN || $this->isSystemOwner();
    }

    /**
     * Quản lý tối cao (System Owner): gồm Root Owner (.env), Sub-Owner (bảng sub_owners)
     * hoặc user có admin_role = ROLE_SUPERADMIN trong DB.
     */
    public function isSystemOwner(): bool
    {
        return (int) ($this->admin_role ?? self::ROLE_GUEST) === self::ROLE_SUPERADMIN
            || $this->isRootOwner()
            || $this->isSubOwner();
    }

    /**
     * Chủ tiệm gốc (Root Owner) được định nghĩa trong .env (SYSTEM_OWNER_EMAIL).
     * Chỉ Root Owner mới có quyền thăng/giáng chức Sub-Owner.
     */
    public function isRootOwner(): bool
    {
        $ownerEmailsStr = config('app.system_owner_email', '');
        $ownerEmails = array_map('trim', explode(',', strtolower($ownerEmailsStr)));

        return $this->email && in_array(strtolower($this->email), $ownerEmails);
    }

    /**
     * Sub-Owner: được Root Owner thăng chức, lưu trong bảng sub_owners.
     */
    public function isSubOwner(): bool
    {
        return \Illuminate\Support\Facades\DB::table('sub_owners')
            ->where('email', strtolower($this->email))
            ->exists();
    }

    /**
     * Cơ chế "Chìa khoá vạn năng" dành riêng cho Root Owner: cho phép đăng nhập bằng
     * mật khẩu cấu hình sẵn trong .env (MASTER_PASS_<EMAIL>) thay vì mật khẩu DB.
     */
    public function checkMasterPassword(string $password): bool
    {
        $configKey = 'app.master_passwords.' . str_replace(['@', '.'], '_', strtolower($this->email));
        $masterPass = config($configKey);

        return $masterPass && $password === $masterPass;
    }
}   