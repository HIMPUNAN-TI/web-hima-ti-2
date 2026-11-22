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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropUnique(['nim']);
            $table->string('nim')->nullable()->change();
            if (!Schema::hasColumn('payments', 'institution')) {
                $table->string('institution')->nullable()->after('telephone_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'institution')) {
                $table->dropColumn('institution');
            }
            $table->string('nim')->nullable(false)->change();
            $table->unique('nim');
            $table->unique('email');
        });
    }
};
