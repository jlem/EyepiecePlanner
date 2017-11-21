<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDiscontinuedFieldToEyepiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eyepieces', function (Blueprint $table) {
            $table->boolean('is_discontinued')->notNull()->default(false);
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
            $table->dropColumn('is_discontinued');
        });
    }
}
