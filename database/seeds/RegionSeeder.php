<?php

use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            ['name' => 'US'],
            ['name' => 'CA'],
            ['name' => 'UK'],
            ['name' => 'EU'],
        ]);
    }
}
