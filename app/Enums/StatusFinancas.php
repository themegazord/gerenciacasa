<?php

namespace App\Enums;

enum StatusFinancas: int
{
  case Aberto = 1;
  case Fechado = 0;

  public function label(): string
  {
    return match ($this) {
      self::Aberto => "Aberto",
      self::Fechado => "Fechado"
    };
  }

  public function badgeClass(): string
  {
    return match ($this) {
      self::Aberto => "badge-success",
      self::Fechado => "badge-error",
    };
  }
}
