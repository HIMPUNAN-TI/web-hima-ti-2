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
            if (!Schema::hasColumn('events', 'quota')) {
                $table->integer('quota')->nullable()->default(100)->after('price');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'registration_code')) {
                $table->string('registration_code')->nullable()->unique()->after('id');
            }
            $table->text('proof_of_payment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'quota')) {
                $table->dropColumn('quota');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'registration_code')) {
                $table->dropUnique(['registration_code']);
                $table->dropColumn('registration_code');
            }
        });
    }
};
