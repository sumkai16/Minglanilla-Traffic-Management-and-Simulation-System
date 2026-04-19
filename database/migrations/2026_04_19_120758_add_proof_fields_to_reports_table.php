<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->text('proof_remarks')->nullable()->after('proof_image');
            $table->decimal('proof_latitude', 10, 8)->nullable()->after('proof_remarks');
            $table->decimal('proof_longitude', 11, 8)->nullable()->after('proof_latitude');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['proof_remarks', 'proof_latitude', 'proof_longitude']);
        });
    }
};