<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class FrontAuthUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'テストユーザ',
            'email' => 'hoge@example.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('pass'),
        ]);
    }
}
