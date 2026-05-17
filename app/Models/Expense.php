<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Unguarded]
class Expense extends Model
{
    use SoftDeletes, HasFactory;

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'date',
            'recurring_start_date' => 'date',
            'recurring_end_date' => 'date',
            'is_auto_generated' => 'boolean',
        ];
    }

    // Uma despesa pertence e um usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Uma despesa pertence a uma categoria
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Uma despesa filha tem pertence a uma despesa pai
    public function parentExpense(): BelongsTo
    {
        return $this->belongsTo(Expense::class, 'parent_expense_id');
    }

    // Uma despesa pai tem muitas despesas filha
    public function childExpenses(): HasMany
    {
        return $this->hasMany(Expense::class,'parent_expense_id');
    }

    // Verifica se a despesa é recorrente
    public function isRecurring(): bool
    {
        return $this->type === 'recurring';
    }

    // Verifica se deve gerar próxima ocorrência em caso de despesas recorrentes
    public function shoulGenerateNextOccurrence(): bool
    {
        if (!$this->isRecurring()) {
            return false;
        }

        if ($this->recurring_end_date && now()->isAfter($this->recurring_end_date)) {
            return false;
        }

        return true;
    }

    // Obtém a data da próxima ocorreência da despesa recorrente
    public function getNextOccurrenceDate(): ?Carbon
    {
        if (!$this->isRecurring()) {
            return null;
        }

        $lastChildExpense = $this->childExpenses()
            ->orderByDate('date', 'desc')
            ->first();

        $baseDate = $lastChildExpense ? $lastChildExpense->date : $this->recurring_start_date;

        return match($this->recurring_frequence) {
            'daily' => $baseDate->copy()->addDay(),
            'weekly' => $baseDate->copy()->addWeek(),
            'monhtly' => $baseDate->copy()->addMonth(),
            default =>null,
        };
    }

    #[Scope]
    protected function forUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    #[Scope]
    protected function recurring(Builder $query): void
    {
        $query->where('type', 'recurring');
    }

    #[Scope]
    protected function oneTime(Builder $query): void
    {
        $query->where('type', 'one-time');
    }

    #[Scope]
    protected function inMonth(Builder $query, int $month, int $year): void
    {
        $query->whereMonth('date', $month)->whereYear('date', $year);
    }

    #[Scope]
    protected function inDateRange(Builder $query, int $startDate, int $endDate): void
    {
        $query->whereBetween('date', [$startDate, $endDate]);
    }
}
