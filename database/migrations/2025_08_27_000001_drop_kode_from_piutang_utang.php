<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('piutang', function (Blueprint $table) {
            if (Schema::hasColumn('piutang', 'kode')) {
                $table->dropColumn('kode');
            }
        });

        Schema::table('utang', function (Blueprint $table) {
            if (Schema::hasColumn('utang', 'kode')) {
                $table->dropColumn('kode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('piutang', function (Blueprint $table) {
            if (!Schema::hasColumn('piutang', 'kode')) {
                $table->string('kode')->nullable();
            }
        });

        Schema::table('utang', function (Blueprint $table) {
            if (!Schema::hasColumn('utang', 'kode')) {
                $table->string('kode')->nullable();
            }
        });
    }
};


