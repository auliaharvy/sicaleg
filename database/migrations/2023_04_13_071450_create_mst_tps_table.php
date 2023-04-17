<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstTpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_tps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('desa_id');
            $table->string('no_tps');
            $table->integer('jml_pemilih')
            $table->timestamps();

            $table->foreign('desa_id')->references('id')->on->('mst_desas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_tps');
    }
}
