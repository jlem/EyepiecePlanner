<?php

use Illuminate\Database\Seeder;

class ProductLinesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_lines')->insert([
            // Agena
            ['manufacturer_id' => 1, 'name' => 'Starguider'],
            ['manufacturer_id' => 1, 'name' => 'EWA'],
            ['manufacturer_id' => 1, 'name' => 'SWA'],
            ['manufacturer_id' => 1, 'name' => 'WA'],

            // APM
            ['manufacturer_id' => 2, 'name' => 'Ultra Flat'],
            ['manufacturer_id' => 2, 'name' => 'Ultra Wide'],

            // Astro-Tech
            ['manufacturer_id' => 3, 'name' => 'Value Line Plossl'],
            ['manufacturer_id' => 3, 'name' => 'High Grade Plossl'],
            ['manufacturer_id' => 3, 'name' => 'Series 6'],
            ['manufacturer_id' => 3, 'name' => 'Titan'],
            ['manufacturer_id' => 3, 'name' => 'Titan Type II'],
            ['manufacturer_id' => 3, 'name' => 'Paradigm'],

            // Baader
            ['manufacturer_id' => 4, 'name' => 'Classic Q'],
            ['manufacturer_id' => 4, 'name' => 'Classic Ortho'],
            ['manufacturer_id' => 4, 'name' => 'Classic Plossl'],
            ['manufacturer_id' => 4, 'name' => 'Hyperion'],
            ['manufacturer_id' => 4, 'name' => 'Hyperion - Aspheric'],
            ['manufacturer_id' => 4, 'name' => 'Morpheus'],

            // Bresser
            ['manufacturer_id' => 5, 'name' => '70° series'],

            // BST
            ['manufacturer_id' => 6, 'name' => 'Flat Field'],
            ['manufacturer_id' => 6, 'name' => 'Ultra Wide'],

            // Burgess Optical
            ['manufacturer_id' => 7, 'name' => 'Erfle'],
            ['manufacturer_id' => 7, 'name' => 'Symmetrical'],
            ['manufacturer_id' => 7, 'name' => 'Planetary'],

            // Celestron
            ['manufacturer_id' => 8, 'name' => 'Luminos'],
            ['manufacturer_id' => 8, 'name' => 'Omni'],
            ['manufacturer_id' => 8, 'name' => 'Ultima Duo'],
            ['manufacturer_id' => 8, 'name' => 'X-Cel'],

            // Docter
            ['manufacturer_id' => 9, 'name' => 'Ultra Wide'],

            // Edmund Optics
            ['manufacturer_id' => 10, 'name' => 'RKE'],

            // Explore Scientific
            ['manufacturer_id' => 11, 'name' => '68° series'],
            ['manufacturer_id' => 11, 'name' => '82° series'],
            ['manufacturer_id' => 11, 'name' => '92° series'],
            ['manufacturer_id' => 11, 'name' => '100° series'],
            ['manufacturer_id' => 11, 'name' => '120° series'],

            // GSO
            ['manufacturer_id' => 12, 'name' => 'Plossl'],
            ['manufacturer_id' => 12, 'name' => 'SuperView'],

            // High Point
            ['manufacturer_id' => 13, 'name' => 'Plossl'],
            ['manufacturer_id' => 13, 'name' => 'SuperView'],

            // Kasai Trading Co.
            ['manufacturer_id' => 14, 'name' => 'AstroPlan'],

            // Kokusai Kohki
            ['manufacturer_id' => 15, 'name' => 'Fujiyama HD-OR'],

            // Levenhuk
            ['manufacturer_id' => 16, 'name' => 'LER'],
            ['manufacturer_id' => 16, 'name' => 'ED'],
            ['manufacturer_id' => 16, 'name' => 'ER20 WA'],

            // Lunt Solar
            ['manufacturer_id' => 17, 'name' => 'Flat Field'],

            // Masuyama
            ['manufacturer_id' => 18, 'name' => '46° series'],
            ['manufacturer_id' => 18, 'name' => '52° series'],
            ['manufacturer_id' => 18, 'name' => '53° series'],
            ['manufacturer_id' => 18, 'name' => '85° series'],

            // Meade
            ['manufacturer_id' => 19, 'name' => 'Series 5000 Mega Wide'],
            ['manufacturer_id' => 19, 'name' => 'Series 5000 Ultra Wide'],
            ['manufacturer_id' => 19, 'name' => 'Series 5000 HD-60'],
            ['manufacturer_id' => 19, 'name' => 'Series 4000 Plossl'],
            ['manufacturer_id' => 19, 'name' => 'Series 3000 Plossl'],

            // Orion
            ['manufacturer_id' => 20, 'name' => 'Sirius'],
            ['manufacturer_id' => 20, 'name' => 'Edge-On'],
            ['manufacturer_id' => 20, 'name' => 'Stratus'],
            ['manufacturer_id' => 20, 'name' => 'Q70'],
            ['manufacturer_id' => 20, 'name' => 'Expanse'],
            ['manufacturer_id' => 20, 'name' => 'DeepView'],
            ['manufacturer_id' => 20, 'name' => 'E-Series'],

            // Pentax
            ['manufacturer_id' => 21, 'name' => 'SMC XW'],
            ['manufacturer_id' => 21, 'name' => 'SMC XF'],

            // SkyWatcher
            ['manufacturer_id' => 22, 'name' => 'Plossl'],
            ['manufacturer_id' => 22, 'name' => 'Super Wide'],
            ['manufacturer_id' => 22, 'name' => 'Ultra Wide'],
            ['manufacturer_id' => 22, 'name' => 'Extra Flat'],
            ['manufacturer_id' => 22, 'name' => 'Panaview'],
            ['manufacturer_id' => 22, 'name' => 'Aero ED'],
            ['manufacturer_id' => 22, 'name' => 'Nirvana'],
            ['manufacturer_id' => 22, 'name' => 'Sky Panorama'],
            ['manufacturer_id' => 22, 'name' => 'Myriad'],

            // StellarVue
            ['manufacturer_id' => 23, 'name' => 'Plossl'],
            ['manufacturer_id' => 23, 'name' => 'Ultra Wide'],
            ['manufacturer_id' => 23, 'name' => 'Planetary'],
            ['manufacturer_id' => 23, 'name' => 'Optimus'],

            // Sterling
            ['manufacturer_id' => 24, 'name' => 'Plossl'],

            // Takahashi
            ['manufacturer_id' => 25, 'name' => 'Ultra Wide'],
            ['manufacturer_id' => 25, 'name' => 'LER ED'],

            // Televue
            ['manufacturer_id' => 26, 'name' => 'Plossl'],
            ['manufacturer_id' => 26, 'name' => 'Radian'],
            ['manufacturer_id' => 26, 'name' => 'Panoptic'],
            ['manufacturer_id' => 26, 'name' => 'Nagler Type-4'],
            ['manufacturer_id' => 26, 'name' => 'Nagler Type-5'],
            ['manufacturer_id' => 26, 'name' => 'Nagler Type-6'],
            ['manufacturer_id' => 26, 'name' => 'Delos'],
            ['manufacturer_id' => 26, 'name' => 'Delite'],
            ['manufacturer_id' => 26, 'name' => 'Ethos'],

            // TMB Optical
            ['manufacturer_id' => 27, 'name' => 'Planetary II'],

            // TS Optics
            ['manufacturer_id' => 28, 'name' => 'Plossl'],
            ['manufacturer_id' => 28, 'name' => 'Super Plossl'],
            ['manufacturer_id' => 28, 'name' => 'Planetary HR'],
            ['manufacturer_id' => 28, 'name' => 'ED'],
            ['manufacturer_id' => 28, 'name' => 'Edge-On'],
            ['manufacturer_id' => 28, 'name' => 'Expanse'],
            ['manufacturer_id' => 28, 'name' => 'WA'],
            ['manufacturer_id' => 28, 'name' => 'SWA'],
            ['manufacturer_id' => 28, 'name' => 'UWA'],
            ['manufacturer_id' => 28, 'name' => 'XWA'],
            ['manufacturer_id' => 28, 'name' => 'Paragon'],
            ['manufacturer_id' => 28, 'name' => 'Erfle'],
            ['manufacturer_id' => 28, 'name' => 'SuperView'],

            // University Optics
            ['manufacturer_id' => 29, 'name' => 'HD Orthoscopic'],
            ['manufacturer_id' => 29, 'name' => '82° series (1.25")'],
            ['manufacturer_id' => 29, 'name' => '80° series (1.25")'],
            ['manufacturer_id' => 29, 'name' => '70° series (1.25")'],
            ['manufacturer_id' => 29, 'name' => 'WS 80° series (2")'],
            ['manufacturer_id' => 29, 'name' => 'WS 70° series (2")'],

            // Vernonscope
            ['manufacturer_id' => 30, 'name' => 'Brandon'],

            // Vixen Optics
            ['manufacturer_id' => 31, 'name' => 'SSW'],
            ['manufacturer_id' => 31, 'name' => 'HR'],
            ['manufacturer_id' => 31, 'name' => 'LVW'],
            ['manufacturer_id' => 31, 'name' => 'SLV'],
            ['manufacturer_id' => 31, 'name' => 'NPL'],

            // Williams Optics
            ['manufacturer_id' => 32, 'name' => 'SPL Planetary'],
            ['manufacturer_id' => 32, 'name' => 'UWAN'],
            ['manufacturer_id' => 32, 'name' => 'SWAN'],
            ['manufacturer_id' => 32, 'name' => 'XWA'],
        ]);
    }
}