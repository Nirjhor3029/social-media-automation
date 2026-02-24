<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('whstapp_subscriber_id')->nullable();
            $table->foreign('whstapp_subscriber_id')->references('id')->on('whstapp_subscribers')->onDelete('cascade');
            $table->text('question');
            $table->longText('answer');
            $table->integer('hit_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_queries');
    }
};
