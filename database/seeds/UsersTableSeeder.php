<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->attachRole('super_admin');
        // DB::table('role_user')->insert([
        //     'role_id'=>'1',
        //     'user_id'=>'1',
        //     'user_type'=>'',
        // ]);
    }
}
