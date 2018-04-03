<?php

use Illuminate\Database\Seeder;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'name'=>'admin',
        	'email'=>'9wimu9@gmail.com',
        	'password'=>bcrypt('123456'),
            'value_type'=>'admin'
        ]);
    }
}
