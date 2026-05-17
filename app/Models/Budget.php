<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Unguarded]
class Budget extends Model
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'month' => 'integer',
            'year' => 'integer',
        ];
    }

    // Um orçamento pertence a um usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Um orçamento pertence a uma categoria
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Obtenção do valor gasto no mês
    public function getSpentAmount(): float
    {
        if ($this->category_id) {
            return $this->category->getTotalSpentForMonth($this->month, $this->year);
        }

        return Expense::forUser($this->user_id)
            ->inMouth($this->month, $this->year)
            ->sum('amount');
    }

    // Obtenção do valor restante do orçamento
    public function getRemainingAumont(): float
    {
        return $this->amount - $this->getSpentAmount();
    }

    // Obtenção da porcentagem total utilizada o roçamento
    public function getPercentageUsed(): float
    {
        if ($this->amount == 0) {
            return 0;
        }

        return ($this->getSpentAmount() / $this->amount) *100;
    }

    // Verifica se o orçamento estorou
    public function isOverBudget(): bool
    {
        return $this->getSpentAmount() > $this->amount;
    }















}
