<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function bancos(): HasMany
  {
    return $this->hasMany(Banco::class);
  }

  public function categoriaFinancas(): HasMany
  {
    return $this->hasMany(CategoriaFinanca::class);
  }

  public function receitas(): HasMany
  {
    return $this->hasMany(Receita::class);
  }

  public function despesas(): HasMany
  {
    return $this->hasMany(Despesa::class);
  }

  public function receitaBaixas(): HasMany
  {
    return $this->hasMany(ReceitaBaixa::class);
  }

  public function formasPagamento(): array
  {
    return [
      ['id' => 'dinheiro', 'name' => 'Dinheiro'],
      ['id' => 'pix', 'name' => 'Pix'],
      ['id' => 'transferencia', 'name' => 'Transferência Bancária'],
      ['id' => 'credito', 'name' => 'C. Crédito'],
      ['id' => 'debito', 'name' => 'C. Débito'],
    ];
  }

  public function retornaFormaPagamento($fp): string {
    return collect($this->formasPagamento())->firstWhere('id', $fp)['name'] ?? null;
  }
}
