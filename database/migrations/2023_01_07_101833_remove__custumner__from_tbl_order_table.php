<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCustumnerFromTblOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order', function (Blueprint $table) {
            //
            Schema::dropIfExists('tbl_order');
            $table->bigIncrements('order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('shipping_id');
            $table->integer('total');
            $table->string('order_date', 50);
            $table->string('order_code', 50);
            $table->integer('order_status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_order', function (Blueprint $table) {
            //
        });
    }
}
