<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnecSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onec_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('session_id');
            $table->string('session_zip_name')->nullable();
            $table->string('session_folder_name')->nullable();
            $table->string('session_full_path')->nullable();
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
        Schema::dropIfExists('onec_sessions');
    }
}
