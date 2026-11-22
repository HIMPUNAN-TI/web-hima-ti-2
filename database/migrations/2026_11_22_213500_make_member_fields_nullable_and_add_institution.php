<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('nim')->nullable()->change();
            $table->string('telephone_number')->nullable()->change();
            $table->string('prodi')->nullable()->change();
            $table->string('generation')->nullable()->change();
            if (!Schema::hasColumn('members', 'institution')) {
                $table->string('institution')->nullable()->after('prodi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'institution')) {
                $table->dropColumn('institution');
            }
        });
    }
};
