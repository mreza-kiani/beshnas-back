<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');

            $table->string('text');
            $table->integer('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')
                ->on('questions')->onDelete('cascade');

            $table->integer('mind')->nullable();
            $table->integer('energy')->nullable();
            $table->integer('nature')->nullable();
            $table->integer('tactics')->nullable();
            $table->integer('identity')->nullable();

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
        Schema::drop('options');
    }
}
