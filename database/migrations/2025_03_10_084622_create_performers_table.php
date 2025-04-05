<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformersTable extends Migration
{
    public function up()
    {
        Schema::create('performers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->string('promo_code', 255)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->char('passport_serials', 9)->nullable();
            $table->date('driver_license_serials')->nullable();
            $table->date('expirated_driver_license')->nullable();
            $table->date('expirated_passport')->nullable();
            $table->string('address', 255)->nullable();
            $table->double('rating')->default(0.98);
            $table->enum('status', ['0', '1'])->default('0');
            $table->string('login', 255)->nullable();
            $table->string('password', 255);
            $table->boolean('is_free')->default(true);
            $table->string('fcm_token', 255)->nullable();
            $table->string('register_from', 255)->nullable();
            $table->text('dop_info')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->boolean('is_on_shift')->default(true);
            $table->boolean('is_online')->default(false);
            $table->string('socket_id', 255)->nullable();
            $table->decimal('rating_by_client', 8, 7)->default(5.0000000);
            $table->timestamp('deleted_at')->nullable();
            $table->enum('photo_control_status', ['ACCEPTED', 'IN_PROCESS', 'NOT_ACCEPTED'])->default('NOT_ACCEPTED');
            $table->double('activity')->default(100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performers');
    }
}
