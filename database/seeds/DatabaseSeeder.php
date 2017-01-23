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

        DB::table('roles')->insert([
            'name' => 'Admin',
            'is_admin' => true
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);

        $this->call(ManufacturersTableSeeder::class);
        $this->call(ProductLinesTableSeeder::class);
        $this->call(EyepiecesTableSeeder::class);
    }
}
