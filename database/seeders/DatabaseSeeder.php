<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use App\Models\UserMenu;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Role::create([
            'name'  =>  'Admin',
            'description'   =>  'Administrator',
        ]);

        Role::create([
            'name'  =>  'IT',
            'description'   =>  'IT',
        ]);

        Menu::create([
            'label' =>  'Dashboard',
            'active_value'  =>  '/',
            'url'   =>  '/',
            'icon'  =>  'fas fa-tachometer-alt',
            'parent'    =>  0,
            'index' =>  1
        ]);

        Menu::create([
            'label' =>  'Managemen Role',
            'active_value'  =>  'master/roles*',
            'url'   =>  '/master/roles',
            'icon'  =>  'fas fa-tag',
            'parent'    =>  0,
            'index' =>  9995
        ]);

        Menu::create([
            'label' =>  'Managemen User Role',
            'active_value'  =>  'user/role*',
            'url'   =>  '/user/role',
            'icon'  =>  'fas fa-user-tag',
            'parent'    =>  0,
            'index' =>  9996
        ]);

        Menu::create([
            'label' =>  'Managemen Menu',
            'active_value'  =>  'user/menus*',
            'url'   =>  '/user/menus',
            'icon'  =>  'fas fa-list',
            'parent'    =>  0,
            'index' =>  9997
        ]);

        Menu::create([
            'label' =>  'Managemen User',
            'active_value'  =>  'master/users*',
            'url'   =>  '/master/users',
            'icon'  =>  'fas fa-users-cog',
            'parent'    =>  0,
            'index' =>  9998
        ]);

        Menu::create([
            'label' =>  'Logout',
            'active_value'  =>  null,
            'url'   =>  null,
            'icon'  =>  'fas fa-sign-out-alt',
            'parent'    =>  0,
            'index' =>  9999
        ]);

        UserRole::create([
            'username'  =>  'admin',
            'role_id'   =>  1
        ]);

        UserRole::create([
            'username'  =>  'semy',
            'role_id'   =>  2
        ]);

        UserRole::create([
            'username'  =>  'lana',
            'role_id'   =>  2
        ]);

        UserRole::create([
            'username'  =>  'andre',
            'role_id'   =>  2
        ]);

        UserRole::create([
            'username'  =>  'akbar',
            'role_id'   =>  2
        ]);

        UserMenu::create([
            'role_id'  =>  1,
            'menu_id'   =>  1
        ]);

        UserMenu::create([
            'role_id'  =>  1,
            'menu_id'   =>  2
        ]);

        UserMenu::create([
            'role_id'  =>  1,
            'menu_id'   =>  3
        ]);

        UserMenu::create([
            'role_id'  =>  1,
            'menu_id'   =>  4
        ]);

        UserMenu::create([
            'role_id'  =>  1,
            'menu_id'   =>  5
        ]);

        UserMenu::create([
            'role_id'  =>  1,
            'menu_id'   =>  6
        ]);

        UserMenu::create([
            'role_id'  =>  2,
            'menu_id'   =>  1
        ]);

        UserMenu::create([
            'role_id'  =>  2,
            'menu_id'   =>  2
        ]);

        UserMenu::create([
            'role_id'  =>  2,
            'menu_id'   =>  3
        ]);

        UserMenu::create([
            'role_id'  =>  2,
            'menu_id'   =>  4
        ]);

        UserMenu::create([
            'role_id'  =>  2,
            'menu_id'   =>  5
        ]);

        UserMenu::create([
            'role_id'  =>  2,
            'menu_id'   =>  6
        ]);
    }
}
