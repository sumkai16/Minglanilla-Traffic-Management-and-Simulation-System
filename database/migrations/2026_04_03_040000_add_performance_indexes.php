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
        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'users_role_idx');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'reports_status_created_at_idx');
            $table->index(['user_id', 'status', 'created_at'], 'reports_user_status_created_at_idx');
            $table->index(['assigned_to', 'status', 'assigned_at'], 'reports_assigned_status_assigned_at_idx');
            $table->index(['issue_type', 'created_at'], 'reports_issue_type_created_at_idx');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'announcements_published_at_idx');
            $table->index(['priority', 'is_published'], 'announcements_priority_published_idx');
            $table->index(['created_by', 'created_at'], 'announcements_created_by_created_at_idx');
        });

        Schema::table('traffic_advisories', function (Blueprint $table) {
            $table->index(['created_by', 'status', 'start_date'], 'traffic_advisories_author_status_start_idx');
            $table->index(['status', 'start_date', 'end_date'], 'traffic_advisories_status_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traffic_advisories', function (Blueprint $table) {
            $table->dropIndex('traffic_advisories_author_status_start_idx');
            $table->dropIndex('traffic_advisories_status_date_idx');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex('announcements_published_at_idx');
            $table->dropIndex('announcements_priority_published_idx');
            $table->dropIndex('announcements_created_by_created_at_idx');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropIndex('reports_status_created_at_idx');
            $table->dropIndex('reports_user_status_created_at_idx');
            $table->dropIndex('reports_assigned_status_assigned_at_idx');
            $table->dropIndex('reports_issue_type_created_at_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_idx');
        });
    }
};
