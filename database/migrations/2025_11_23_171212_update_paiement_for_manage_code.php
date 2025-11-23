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
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('code')->nullable();
            $table->unique('code');
            $table->boolean('has_enter')->default(false);
            $table->boolean('has_eat')->default(false);
            $table->foreignId('enter_by')->nullable()->constrained('users');
            $table->foreignId('eat_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
