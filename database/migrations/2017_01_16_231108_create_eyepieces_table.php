<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEyepiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eyepieces', function (Blueprint $table) {
            $table->increments('id');
            $table->float('apparent_field');
            $table->float('focal_length');
            $table->float('eye_relief');
            $table->float('field_stop');
            $table->string('barrel_size');
            $table->integer('product_line_id');
            $table->integer('manufacturer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eyepieces');
    }
}
