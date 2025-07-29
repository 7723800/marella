<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_id');
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity')->default(1);
            $table->string('description')->nullable();
            $table->string('composition')->nullable();
            $table->string('features')->nullable();
            $table->string('care')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('final_price');
            $table->integer('source_state_id');
            $table->integer('manufacture_state_id');
            $table->integer('brand_id');
            $table->integer('color_id');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('guide_sizes_id')->nullable();
            $table->boolean('published')->default(1);
            $table->string('slug');
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
        Schema::dropIfExists('items');
    }
}
