<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('expense') || Schema::hasTable('expenses')) {
            return;
        }

        Schema::create('expense', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->text('details')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('active_amount', 10, 2);
            $table->char('currency', 3)->default('GBP');

            $table->boolean('is_recurring')->default(true);
            $table->integer('day_of_month')->nullable();
            $table->date('transaction_date')->nullable()->index();
            $table->date('due_date')->nullable()->index();

            $table->timestamps();

            $table->index(['user_id', 'is_recurring']);
            $table->index(['user_id', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense');
        Schema::dropIfExists('expenses');
    }
};