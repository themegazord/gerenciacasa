<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoriaFinanca extends Model
{
  protected $fillable = [
    'user_id',
    'nome',
    'tipo',
    'cor',
    'ativo'
  ];

  public function usuario(): BelongsTo {
    return $this->belongsTo(User::class);
  }
}
