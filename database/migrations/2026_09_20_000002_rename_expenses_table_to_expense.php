<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('expenses') && ! Schema::hasTable('expense')) {
            Schema::rename('expenses', 'expense');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('expense') && ! Schema::hasTable('expenses')) {
            Schema::rename('expense', 'expenses');
        }
    }
};

