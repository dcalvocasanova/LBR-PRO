<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskImprove extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'effort' => 'array',
      'risk' => 'array',
      'addedValue' => 'array',
      'correlation' => 'array'
  ];
}
