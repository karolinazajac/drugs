<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_note', function (Blueprint $table) {
            $table->integer('image_id')->unsigned();
            $table->foreign('image_id')
                ->references('id')->on('images')->onDelete('cascade');
            $table->integer('note_id')->unsigned();
            $table->foreign('note_id')
                ->references('id')->on('notes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_note');
    }
}
