<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $table_name = null;

        if (Schema::hasTable('expense')) {
            $table_name = 'expense';
        } elseif (Schema::hasTable('expenses')) {
            $table_name = 'expenses';
        }

        if (!$table_name) {
            return;
        }

        $has_user_id = Schema::hasColumn($table_name, 'user_id');

        if ($has_user_id) {
            return;
        }

        Schema::table($table_name, function (Blueprint $table): void {
            // Nullable to avoid breaking existing rows; enforce later after backfill if needed.
            $table->foreignId('user_id')->nullable()->after('id')->index();
        });
    }

    public function down(): void
    {
        $table_name = null;

        if (Schema::hasTable('expense')) {
            $table_name = 'expense';
        } elseif (Schema::hasTable('expenses')) {
            $table_name = 'expenses';
        }

        if (!$table_name) {
            return;
        }

        if (!Schema::hasColumn($table_name, 'user_id')) {
            return;
        }

        Schema::table($table_name, function (Blueprint $table): void {
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};

