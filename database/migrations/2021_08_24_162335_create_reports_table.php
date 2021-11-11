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
            $table->text('request');
            $table->text('respond')->nullable();
            $table->boolean('is_warning')->default(false);
            $table->timestamps();

            $table->foreignId('ban_reason_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->integer('reportable_id')->unsigned();
            $table->string('reportable_type');
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
