<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTelescopesTableWithEyepieceSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telescopes', function (Blueprint $table) {
            $table->string('max_eyepiece_size')->default('1.25');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telescopes', function (Blueprint $table) {
            $table->dropColumn('max_eyepiece_size');
        });
    }
}
