<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->decimal('bid_amount',18,8)->default(0);
            $table->decimal('shipping_cost',18,8)->default(0);
            $table->decimal('total_amount',18,8)->default(0);
            $table->boolean('winner_selection')->default(0)->comment('0 = Not selected, 1 = Selected');
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
        Schema::dropIfExists('bids');
    }
}
