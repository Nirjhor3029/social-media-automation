<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('permissions')->where('title', 'temnplate_create')->update(['title' => 'message_template_create']);
        DB::table('permissions')->where('title', 'temnplate_edit')->update(['title' => 'message_template_edit']);
        DB::table('permissions')->where('title', 'temnplate_show')->update(['title' => 'message_template_show']);
        DB::table('permissions')->where('title', 'temnplate_delete')->update(['title' => 'message_template_delete']);
        DB::table('permissions')->where('title', 'temnplate_access')->update(['title' => 'message_template_access']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->where('title', 'message_template_create')->update(['title' => 'temnplate_create']);
        DB::table('permissions')->where('title', 'message_template_edit')->update(['title' => 'temnplate_edit']);
        DB::table('permissions')->where('title', 'message_template_show')->update(['title' => 'temnplate_show']);
        DB::table('permissions')->where('title', 'message_template_delete')->update(['title' => 'temnplate_delete']);
        DB::table('permissions')->where('title', 'message_template_access')->update(['title' => 'temnplate_access']);
    }
};
