<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['PENDING', 'PAID', 'SHIPPED'])->index();
            $table->integer('user_id')->index();
            $table->text('address');
            $table->float('sum_price')->nullable();
            $table->float('sum_weight')->nullable();
            $table->float('shipping_fee')->nullable();
            $table->integer('unique_id')->nullable();
            $table->float('amount')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
