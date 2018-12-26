<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::where('email','guest@example.com')->delete();
    	User::where('email','admin@example.com')->delete();

    	$guest = User::create([
    		'name' => 'guest',
    		'email' => 'guest@example.com',
    		'password' => bcrypt('password')
    	]);

    	$admin = User::create([
    		'name' => 'admin',
    		'role' => 'OPERATION_MANAGER',
    		'email' => 'admin@example.com',
    		'password' => bcrypt('password')
    	]);
    }
}
