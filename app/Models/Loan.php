<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_id',
        'user_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    // Relacionamento com Book
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Relacionamento com User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Verificar se está atrasado
    public function isOverdue(): bool
    {
        return $this->status === 'active' && Carbon::now()->gt($this->due_date);
    }

    // Dias até o vencimento
    public function daysUntilDue(): int
    {
        return $this->status === 'active' 
            ? Carbon::now()->diffInDays($this->due_date, false) 
            : 0;
    }

    // Marcar como devolvido
    public function markAsReturned(): void
    {
        $this->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);
        
        $this->book->incrementAvailable();
    }

    // Boot para configurações automáticas
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            if (empty($loan->loan_date)) {
                $loan->loan_date = now();
            }
            
            if (empty($loan->due_date)) {
                $loan->due_date = now()->addDays(14);
            }
        });

        static::created(function ($loan) {
            $loan->book->decrementAvailable();
        });
    }
}