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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('member_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nim')->unique();
            $table->string('telephone_number');
            $table->text('proof_of_payment');
            $table->string('status');
            $table->text('decline_reason')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
