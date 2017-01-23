<?php

use Illuminate\Database\Seeder;

class ManufacturersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manufacturers')->insert([
            ['name' => 'Agena'],
            ['name' => 'APM'],
            ['name' => 'Astro Tech'],
            ['name' => 'Baader'],
            ['name' => 'Bresser'],
            ['name' => 'BST'],
            ['name' => 'Burgess Optical'],
            ['name' => 'Celestron'],
            ['name' => 'Docter'],
            ['name' => 'Edmund Optics'],
            ['name' => 'Explore Scientific'],
            ['name' => 'GSO'],
            ['name' => 'High Point'],
            ['name' => 'Kasai Trading Co'],
            ['name' => 'Kokusai Kohki'],
            ['name' => 'Levenhuk'],
            ['name' => 'Lunt Solar'],
            ['name' => 'Masuyama'],
            ['name' => 'Meade'],
            ['name' => 'Orion'],
            ['name' => 'Pentax'],
            ['name' => 'SkyWatcher'],
            ['name' => 'StellarVue'],
            ['name' => 'Sterling'],
            ['name' => 'Takahashi'],
            ['name' => 'Televue'],
            ['name' => 'TMB Optical'],
            ['name' => 'TS Optics'],
            ['name' => 'University Optics'],
            ['name' => 'Vernonscope'],
            ['name' => 'Vixen Optics'],
            ['name' => 'Williams Optics'],
        ]);
    }
}