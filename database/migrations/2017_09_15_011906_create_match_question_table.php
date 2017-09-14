<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_question', function (Blueprint $table) {
            $table->integer('match_id')->unsigned()->nullable();
            $table->foreign('match_id')->references('id')
                ->on('matches')->onDelete('cascade');

            $table->integer('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')
                ->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match_question');
    }
}
