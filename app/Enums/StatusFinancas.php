<?php

namespace App\Enums;

enum StatusFinancas: string
{
  case Aberto = true;
  case Fechado = false;

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
