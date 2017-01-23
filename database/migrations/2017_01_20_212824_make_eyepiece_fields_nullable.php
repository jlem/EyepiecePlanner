<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEyepieceFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `eyepieces` MODIFY `field_stop` DOUBLE(8,2) NULL;');
        DB::statement('ALTER TABLE `eyepieces` MODIFY `apparent_field` DOUBLE(8,2) NULL;');
        DB::statement('ALTER TABLE `eyepieces` MODIFY `eye_relief` DOUBLE(8,2) NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `eyepieces` MODIFY `field_stop` DOUBLE(8,2) NOT NULL;');
        DB::statement('ALTER TABLE `eyepieces` MODIFY `apparent_field` DOUBLE(8,2) NOT NULL;');
        DB::statement('ALTER TABLE `eyepieces` MODIFY `eye_relief` DOUBLE(8,2) NOT NULL;');
    }
}
