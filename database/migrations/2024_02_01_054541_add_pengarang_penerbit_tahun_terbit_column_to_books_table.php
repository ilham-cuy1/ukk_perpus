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
        Schema::table('books', function (Blueprint $table) {
            $table->string('pengarang', 255)->nullable()->after('title');
            $table->string('penerbit', 255)->nullable()->after('pengarang');
            $table->string('tahun_terbit', 255)->nullable()->after('penerbit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'pengarang')) {
                $table->dropColumn('pengarang');
            }

            if (Schema::hasColumn('books', 'penerbit')) {
                $table->dropColumn('penerbit');
            }

            if (Schema::hasColumn('books', 'tahun_terbit')) {
                $table->dropColumn('tahun_terbit');
            }
        });
    }
};
