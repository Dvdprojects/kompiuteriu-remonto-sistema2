<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormForComputerFixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas', function (Blueprint $table) {
            $table->id();
            $table->string('computer_brand');
            $table->string('computer_model');
            $table->string('comment');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('delivery');
            $table->string('busena');
            $table->string('saskaitos_nr');
            $table->integer('comment_state')->default(0);
            $table->integer('user_id');
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
        Schema::dropIfExists('formas');
    }
}
