<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWhatsappGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('whatsapp_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('whstapp_subscriber_id')->nullable();
            $table->foreign('whstapp_subscriber_id', 'whstapp_subscriber_fk_10802019')->references('id')->on('whstapp_subscribers');
        });
    }
}
