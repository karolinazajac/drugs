<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabinetDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabinet_drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('ean');
            $table->foreign('ean')
                ->references('ean')->on('drugs');
            $table->integer('cabinet_id')->unsigned();
            $table->foreign('cabinet_id')
                ->references('id')->on('cabinets')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('expiration_date');
            $table->integer('price');
            $table->integer('current_state');
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
        Schema::dropIfExists('cabinet_drugs');
    }
}
