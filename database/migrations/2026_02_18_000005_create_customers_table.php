<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('telegram')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
