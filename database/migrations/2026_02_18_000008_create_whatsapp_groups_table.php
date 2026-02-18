<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_identification')->nullable();
            $table->string('subject')->nullable();
            $table->string('subject_owner')->nullable();
            $table->string('subject_time')->nullable();
            $table->string('creation')->nullable();
            $table->integer('size')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
