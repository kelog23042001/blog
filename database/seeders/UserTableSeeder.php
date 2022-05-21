<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        
        $adminroles = Roles::where('name', 'admin')->first();
        $authorroles = Roles::where('name', 'author')->first();
        $userroles = Roles::where('name', 'user')->first();

        $admin = Admin::create([
            'admin_name' => 'khanh',
            'admin_password'=> md5('123456'),
            'admin_email'=> 'khanhadmin@gmail.com',
            'admin_phone' => '123456789'
        ]);
        $author = Admin::create([
            'admin_name' => 'khanhauthor',
            'admin_password'=> md5('123456'),
            'admin_email'=> 'khanhauthor@gmail.com',
            'admin_phone' => '123456789'
        ]);
        $user = Admin::create([
            'admin_name' => 'adminuser',
            'admin_password'=> md5('123456'),
            'admin_email'=> 'khanhuser@gmail.com',
            'admin_phone' => '123456789'
        ]);

        $admin->roles()->attach($adminroles);
        $author->roles()->attach($authorroles);
        $user->roles()->attach($userroles);

    }
}
