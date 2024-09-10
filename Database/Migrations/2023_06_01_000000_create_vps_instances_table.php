<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpsInstancesTable extends Migration
{
    public function up()
    {
        Schema::create('vps_instances', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->string('full_name');
            $table->string('email');
            $table->string('ip_address');
            $table->dateTime('creation_date');
            $table->string('status');
            $table->dateTime('expiration_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vps_instances');
    }
}