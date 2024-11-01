<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MahasiswaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function viewAny(User $user)
{
    return $user->role === 'admin'; // Hanya admin yang bisa melihat semua data mahasiswa
}

    public function __construct()
    {
        //
    }
}
