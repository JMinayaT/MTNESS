<?php

namespace Modules\Auth\Database\Seeds;

use Illuminate\Database\Seeder;
use  Modules\Auth\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
            'active' => true,
            'remember_token' => str_random(10),
        ]);

        factory(User::class,50)->create();
    }
}