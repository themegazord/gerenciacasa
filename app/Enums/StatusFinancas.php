<?php

namespace App\Enums;

enum StatusFinancas: string
{
  case Aberto = "A";
  case Fechado = "F";

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
