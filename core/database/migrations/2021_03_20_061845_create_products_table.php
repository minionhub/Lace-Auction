<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0);
            $table->string('name', 100)->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->decimal('min_bid_price',18,8)->default(0);
            $table->decimal('shipping_cost',18,8)->default(0);
            $table->string('delivery_time', 30)->nullable();
            $table->json('keywords')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('others_info')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('products');
    }
}
