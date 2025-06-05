<?php

namespace App\Models;

use App\Enums\TipoCategoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaFinanca extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'nome',
    'tipo',
    'cor',
    'ativo'
  ];

  protected $casts = [
    'tipo' => TipoCategoria::class
  ];

  public function usuario(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function receitas(): HasMany {
    return $this->hasMany(Receita::class);
  }

  public function despesas(): HasMany {
    return $this->hasMany(Despesa::class);
  }
}
