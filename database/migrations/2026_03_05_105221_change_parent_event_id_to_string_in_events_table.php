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
        Schema::table('events', function (Blueprint $table) {
            // Drop foreign key & column lama (only if it exists)
            if (Schema::hasColumn('events', 'parent_event_id')) {
                $table->dropForeign(['parent_event_id']);
                $table->dropColumn('parent_event_id');
            }
            // Tambah column baru sebagai string (only if not already added)
            if (!Schema::hasColumn('events', 'parent_event_name')) {
                $table->string('parent_event_name')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'parent_event_name')) {
                $table->dropColumn('parent_event_name');
            }
            if (!Schema::hasColumn('events', 'parent_event_id')) {
                $table->unsignedBigInteger('parent_event_id')->nullable()->after('name');
                $table->foreign('parent_event_id')->references('id')->on('events')->onDelete('set null');
            }
        });
    }
};
