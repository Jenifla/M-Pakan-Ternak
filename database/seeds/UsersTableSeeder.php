<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'Admin',
                'email'=>'admin@mail.com',
                'password'=>Hash::make('admin1234'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'name'=>'Customer A',
                'email'=>'customer@mail.com',
                'password'=>Hash::make('cus12345'),
                'role'=>'user',
                'status'=>'active'
            ),
        );

        DB::table('users')->insert($data);
    }
}
