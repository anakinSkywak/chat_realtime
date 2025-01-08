<?php

namespace App\Observers;

use App\Models\User;

// class là nơi chứa các observer của model User
// observer là nơi chứa các hàm xử lý các sự kiện của model User
class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function creating(User $user)
    {
        // Gán giá trị mặc định nếu các trường không được truyền
        $user->status = $user->status ?? 'offline'; // Giá trị mặc định cho status
        $user->role = $user->role ?? 'user';       // Giá trị mặc định cho role
        $user->last_active_at = $user->last_active_at ?? now(); // Giá trị mặc định cho last_active_at
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
