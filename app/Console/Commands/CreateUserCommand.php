<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'users:create';

    protected $description = 'Creates a new user';

    public function handle()
    {
        $user['name'] = $this->ask('Name of the new user');
        $user['email'] = $this->ask('Email of the new user');
        $user['password'] = $this->secret('Password of the new user');
        $roleName = $this->choice('Role of the new user', ['admin', 'editor'], 1);
        $role = Role::where('name', $roleName)->first();
        
        DB::transaction(function () use ($user, $role) {
            $user['password'] = Hash::make($user['password']);
            $newUser = User::create($user);
            $newUser->roles()->attach($role->id);
        });
        // if (!$role) {
        //     $this->error('Role not found');

        //     return -1;
        // }
    }
}
