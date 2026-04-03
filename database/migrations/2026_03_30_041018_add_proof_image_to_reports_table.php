<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
            $table->string('proof_image')->nullable()->after('status');
        });

        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending','verified','rejected','assigned','for_verification','resolved') DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
   {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('proof_image');
        });

        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending','verified','rejected','assigned','resolved') DEFAULT 'pending'");
        }
    }
};
