<?php

namespace App\Enums;

enum TipoCategoria: string
{
  case Receita = 'receita';
  case Despesa = 'despesa';

  public function label(): string
  {
    return match ($this) {
      self::Receita => "Receita",
      self::Despesa => "Despesa"
    };
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::Receita => 'badge-success',
      self::Despesa => 'badge-error',
    };
  }
}
