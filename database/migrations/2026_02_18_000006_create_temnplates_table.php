<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemnplatesTable extends Migration
{
    public function up()
    {
        Schema::create('temnplates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
