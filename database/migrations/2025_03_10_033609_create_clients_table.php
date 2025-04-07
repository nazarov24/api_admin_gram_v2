<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('login', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('fcm_token')->nullable();
            $table->tinyInteger('is_online')->default(0);
            $table->string('socket_id', 100)->nullable();
            $table->double('rating')->default(0.98);
            $table->string('device');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->text('dop_info')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
