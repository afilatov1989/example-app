<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionsAndRolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageRecord = new Permission();
        $manageRecord->name = 'manage-record';
        $manageRecord->display_name = 'Manage Records';
        $manageRecord->description = 'Edit records of other users';
        $manageRecord->save();

        $manageUser = new Permission();
        $manageUser->name = 'manage-user';
        $manageUser->display_name = 'Manage Users';
        $manageUser->description = 'Edit existing users';
        $manageUser->save();

        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Administrator';
        $admin->description = 'User is allowed to manage and edit other users and their records';
        $admin->save();
        $admin->attachPermissions([$manageUser, $manageRecord]);

        $manager = new Role();
        $manager->name = 'manager';
        $manager->display_name = 'User Manager';
        $manager->description = 'User is allowed to manage and edit other users';
        $manager->save();
        $manager->attachPermissions([$manageUser]);
    }
}
