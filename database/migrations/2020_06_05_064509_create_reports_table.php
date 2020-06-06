<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('is_approve')->default(0); //to indicate approval status by admin
            $table->integer('fatal')->default(0);
            $table->date('DOB');
            $table->string('relationship');
            $table->string('symptoms');
            $table->string('other_symptoms')->nullable();
            $table->date('diagnosis')->nullable();
            $table->integer('hospital_admission')->nullable();
            $table->string('residential');
            $table->integer('attend_kindergarten');
            $table->string('kindergarten_location')->nullable();
            $table->integer('children_in_kindergarten_infected')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('reports');
    }
}
