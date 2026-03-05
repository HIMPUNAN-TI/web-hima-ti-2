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
            // Drop foreign key & column lama
            $table->dropForeign(['parent_event_id']);
            $table->dropColumn('parent_event_id');
            // Tambah column baru sebagai string
            $table->string('parent_event_name')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('parent_event_name');
            $table->unsignedBigInteger('parent_event_id')->nullable()->after('type');
            $table->foreign('parent_event_id')->references('id')->on('events')->onDelete('set null');
        });
    }
};
