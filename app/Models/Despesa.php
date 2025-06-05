<?php

namespace App\Models;

use App\Enums\StatusFinancas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Despesa extends Model
{
  protected $fillable = [
    'banco_id',
    'categoria_id',
    'despesa_pai_id',
    'status',
    'descricao',
    'valor',
    'valor_aberto',
    'data_vencimento',
    'observacao',
    'recorrente',
  ];

  protected $casts = [
    'status' => StatusFinancas::class
  ];

  public function despesas_filhas(): HasMany
  {
    return $this->hasMany(self::class, 'despesa_pai_id', 'id');
  }

  public function despesa_pai(): BelongsTo
  {
    return $this->belongsTo(self::class, 'despesa_pai_id', 'id');
  }
}
