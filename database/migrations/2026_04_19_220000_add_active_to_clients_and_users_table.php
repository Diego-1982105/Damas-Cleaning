<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('permissions');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
