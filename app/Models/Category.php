<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Unguarded]
class Category extends Model
{
    // Uma categoria pertence a um susário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Uma categoria possui muitas despesas
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    // Uma categoria possui muitos orçamentos
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    // Total de despesas por mês
    public function getTotalSpentForMonth(int $month, int $year)
    {
        return $this->expenses()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');
    }
}
