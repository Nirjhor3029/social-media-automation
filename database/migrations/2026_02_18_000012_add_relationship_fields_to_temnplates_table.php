<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTemnplatesTable extends Migration
{
    public function up()
    {
        Schema::table('temnplates', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_10802004')->references('id')->on('users');
        });
    }
}
