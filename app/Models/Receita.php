<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receita extends Model
{
  protected $fillable = [
    'user_id',
    'banco_id',
    'categoria_id',
    'receita_pai_id',
    'descricao',
    'valor',
    'data',
    'observacao',
    'recorrente',
  ];

  public function usuario(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function banco(): BelongsTo
  {
    return $this->belongsTo(Banco::class);
  }

  public function categoria(): BelongsTo
  {
    return $this->belongsTo(CategoriaFinanca::class);
  }

  public function receitas_filhas(): HasMany
  {
    return $this->hasMany(self::class, 'receita_pai_id', 'id');
  }

  public function receita_pai(): BelongsTo
  {
    return $this->belongsTo(self::class, 'receita_pai_id', 'id');
  }

  public function ehRecorrente(): bool
  {
    return (bool) $this->recorrente;
  }

  public function contemFilhas(): bool
  {
    return $this->receitas_filhas()->exists();
  }
}
