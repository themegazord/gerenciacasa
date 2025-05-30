<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

  public function usuario(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function banco(): BelongsTo {
    return $this->belongsTo(Banco::class);
  }

  public function categoria(): BelongsTo {
    return $this->belongsTo(CategoriaFinanca::class);
  }
}
