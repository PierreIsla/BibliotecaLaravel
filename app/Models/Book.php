<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'isbn',
        'description',
        'publication_year',
        'pages',
        'publisher',
        'language',
        'quantity',
        'available_quantity',
        'cover_image',
        'pdf_file',
        'category_id',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'pages' => 'integer',
        'quantity' => 'integer',
        'available_quantity' => 'integer',
    ];

    // Relacionamento 1:N - Um livro pertence a uma categoria
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relacionamento N:N - Um livro pode ter vários autores
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    // Relacionamento 1:N - Um livro pode ter vários empréstimos
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    // Verificar se o livro está disponível
    public function isAvailable(): bool
    {
        return $this->available_quantity > 0;
    }

    // Decrementar quantidade disponível
    public function decrementAvailable(): void
    {
        if ($this->available_quantity > 0) {
            $this->decrement('available_quantity');
        }
    }

    // Incrementar quantidade disponível
    public function incrementAvailable(): void
    {
        if ($this->available_quantity < $this->quantity) {
            $this->increment('available_quantity');
        }
    }

    // Accessor para URL da capa
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image 
            ? asset('storage/' . $this->cover_image) 
            : null;
    }

    // Accessor para URL do PDF
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_file 
            ? asset('storage/' . $this->pdf_file) 
            : null;
    }
}