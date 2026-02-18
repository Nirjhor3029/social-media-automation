<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhstappSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('whstapp_subscribers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('session')->nullable();
            $table->longText('qr')->nullable();
            $table->datetime('qr_updated_at')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
