<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutonumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autonumbers', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('column_name');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->integer('min_digits');
            $table->bigInteger('next_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autonumbers');
    }
}
