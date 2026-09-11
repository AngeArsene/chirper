<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chirp_bookmarks', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('chirp_comments', function (Blueprint $table) {
            $table->index(['chirp_id', 'created_at']);
            $table->index('user_id');
        });

        Schema::table('chirps', function (Blueprint $table) {
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chirp_bookmarks', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('chirp_comments', function (Blueprint $table) {
            $table->dropIndex(['chirp_id', 'created_at']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('chirps', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });
    }
};
