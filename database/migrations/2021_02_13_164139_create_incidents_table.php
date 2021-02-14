<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 164);
            $table->string('location', 264);
            $table->integer('category')->length(11)->unsigned();
            $table->text('people');
            $table->text('comments');
            $table->string('incident_time', 164);
            $table->string('create_time', 164);
            $table->string('update_time', 164);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
