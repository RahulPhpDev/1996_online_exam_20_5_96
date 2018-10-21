<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         Model::unguard();
 
     // $this->call(UsersTableSeeder::class);
 $this->call(StudentTableSeeder::class);
    // Re enable all mass assignment restrictions
     Model::reguard();
    }
}
