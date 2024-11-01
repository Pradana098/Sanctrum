<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateUserRole extends Command
{
    protected $signature = 'user:update-role {email} {role}';
    protected $description = 'Update role user based on email';

    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->role = $role;
            $user->save();
            $this->info("Role user {$email} telah diubah menjadi {$role}.");
        } else {
            $this->error("User dengan email {$email} tidak ditemukan.");
        }
    }
}
