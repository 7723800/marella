<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfumes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_id');
            $table->string('name');
            $table->string('type_id');
            $table->string('sex_id');
            $table->integer('price');
            $table->integer('quantity')->default(1);
            $table->string('description')->nullable();
            $table->string('composition')->nullable();
            $table->string('features')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('final_price');
            $table->integer('manufacture_state_id');
            $table->integer('brand_id');
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
        Schema::dropIfExists('perfumes');
    }
}
