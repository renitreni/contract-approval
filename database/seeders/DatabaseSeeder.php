<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employer;
use App\Models\OfficialCase;
use App\Models\User;
use App\Models\Worker;
use Silber\Bouncer\Bouncer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param \Silber\Bouncer\Bouncer $bouncer
     * @return void
     */
    public function run(Bouncer $bouncer)
    {
        $user_model = User::create([
            'name'     => 'User',
            'email'    => 'renier.trenuela@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user       = $bouncer->role()->firstOrCreate([
            'name'  => 'User',
            'title' => 'User',
        ]);
        $bouncer->assign($user)->to($user_model);

        // Initialized Admin
        $admin_model = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@site.com',
            'password' => Hash::make('password'),
        ]);

        $admin       = $bouncer->role()->firstOrCreate([
            'name'  => 'admin',
            'title' => 'Administrator',
        ]);
        $bouncer->assign($admin)->to($admin_model);

        $manage_users = $bouncer->ability()->firstOrCreate([
            'name'  => 'manage-users',
            'title' => 'Manage Users',
        ]);
        $bouncer->allow($admin)->to($manage_users);

        $users = $bouncer->ability()->firstOrCreate([
            'name'  => 'users',
            'title' => 'Users',
        ]);
        $bouncer->allow($admin)->to($users);

        $roles = $bouncer->ability()->firstOrCreate([
            'name'  => 'roles',
            'title' => 'Roles',
        ]);
        $bouncer->allow($admin)->to($roles);
        $bouncer->allow($admin)->everything();

        Company::factory()->count(50)->create();
        Worker::factory()->count(50)->create();
        Employer::factory()->count(50)->create();
        OfficialCase::factory()->count(200)->create();
    }
}
