<?php

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->enum('type', ['one-time', 'recurring'])->default('one-time');

            // Recurring expense fields
            $table->enum('recurring_frequency', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->date('recurring_start_date')->nullable();
            $table->date('recurring_end_date')->nullable();
            $table->foreignIdFor(Expense::class, 'parent_expense_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_auto_generated')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
