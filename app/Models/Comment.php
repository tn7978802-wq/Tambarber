<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'announcement_id',
        'user_id',
        'guest_name',
        'content',
        'parent_id',
    ];

    public function announcement(): BelongsTo
        {
            return $this->belongsTo(Announcement::class);
        }

    public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

    /**
     * Tên hiển thị của người bình luận: ưu tiên tài khoản đã đăng nhập,
     * nếu không thì dùng tên khách nhập tay, cuối cùng là "Khách vãng lai".
     */
    public function getDisplayNameAttribute(): string
        {
            if ($this->user) {
                return $this->user->fullname ?? $this->user->name;
            }
            return $this->guest_name ?? 'Khách vãng lai';
        }

    public function replies()
        {
            return $this->hasMany(Comment::class, 'parent_id');
        }
    
}
