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
        DB::table('users')->insert([
            'name' => 'Jon',
            'email' => 'agmlauncher@gmail.com',
            'password' => bcrypt('test')
        ]);

        DB::table('manufacturers')->insert([ 'name' => 'Televue' ]);
        DB::table('manufacturers')->insert([ 'name' => 'Meade' ]);
        DB::table('manufacturers')->insert([ 'name' => 'Celestron' ]);
        // $this->call(UsersTableSeeder::class);
    }
}
