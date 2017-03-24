<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Permission;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name'         => 'admin',
            'display_name' => 'Administrator'
        ]);

        $manager = Role::create([
            'name'         => 'manager',
            'display_name' => 'Politician Manager'
        ]);

        $manageEvent = Permission::create([
            'name' => 'manage-event',
            'display_name' => 'Manage Events'
        ]);

        $admin->attachPermission($manageEvent);
        $manager->attachPermission($manageEvent);

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'renddi@relab.cc',
            'password' => 'renddi'
        ]);

        $user->attachRole($admin);

        $demo = User::create([
            'name' => 'Demo',
            'email' => 'demo@relab.cc',
            'password' => 'demo'
        ]);

        $demo->attachRole($manager);
    }
}
