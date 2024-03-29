<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $fillable = [
    'text',
    'completed',
    'order',
    'start_date',
    'user_id',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected function completed(): Attribute
  {
    return Attribute::make(
      get: static fn(string $value) => (bool)$value,
      set: static fn(string $value) => (int)$value,
    );
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
