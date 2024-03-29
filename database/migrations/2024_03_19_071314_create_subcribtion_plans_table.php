<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcribtion_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('price');
            $table->smallInteger('active_period_in_months');
            $table->json('features');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcribtion_plans');
    }
};
