<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceInformationToEyepieceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eyepieces', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->tinyInteger('region')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eyepieces', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('region');
        });
    }
}
