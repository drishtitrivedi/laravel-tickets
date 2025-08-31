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
        Schema::table('Tickets', function (Blueprint $table) {
            $table->string('category')->nullable()->after('status');
            $table->text('notes')->nullable()->after('category');
            $table->string('explanation')->nullable()->after('notes');
            $table->string('confidence')->nullable()->after('explanation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Tickets', function (Blueprint $table) {
            //
        });
    }
};
