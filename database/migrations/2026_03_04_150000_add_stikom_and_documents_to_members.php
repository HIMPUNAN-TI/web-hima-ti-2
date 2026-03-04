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
        Schema::table('members', function (Blueprint $table) {
            // make existing columns nullable since non-STIKOM users may not provide them
            $table->string('nim')->nullable()->change();
            $table->string('telephone_number')->nullable()->change();
            $table->string('prodi')->nullable()->change();
            $table->string('generation')->nullable()->change();

            // new fields
            $table->boolean('is_stikom')->default(false)->after('email');
            $table->string('ktm_ktp_path')->nullable()->after('generation');
            $table->string('bukti_path')->nullable()->after('ktm_ktp_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['is_stikom', 'ktm_ktp_path', 'bukti_path']);
            // revert nullable to not nullable; be careful could break if null values exist
            $table->string('nim')->nullable(false)->change();
            $table->string('telephone_number')->nullable(false)->change();
            $table->string('prodi')->nullable(false)->change();
            $table->string('generation')->nullable(false)->change();
        });
    }
};
