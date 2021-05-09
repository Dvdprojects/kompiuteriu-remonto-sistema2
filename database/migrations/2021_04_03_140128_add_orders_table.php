<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('saskaitos_nr');
            $table->string('short_comment');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('delivery');
            $table->enum('busena', ['atlikta', 'pateikta', 'priimta', 'gauta', 'taisoma']);
            $table->integer('comment_state')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id', 'orders_to_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
