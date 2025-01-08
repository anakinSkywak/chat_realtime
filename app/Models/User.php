<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use MongoDB\Laravel\Eloquent\Model as EloquentModel;

class User extends EloquentModel implements AuthenticatableContract
{
    use HasApiTokens, Notifiable, AuthenticableTrait;

    /**
     * Tên kết nối cơ sở dữ liệu (MongoDB).
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Tên collection trong MongoDB.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
     * Các thuộc tính có thể gán hàng loạt.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'status',
        'role',
        'last_active_at',
    ];

    /**
     * Các thuộc tính sẽ được ẩn khi trả về JSON.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tự động thêm timestamps (created_at, updated_at).
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Sự kiện để mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (isset($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });
    }
}
