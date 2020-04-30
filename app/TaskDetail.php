<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'PHVA' => 'array',
      'risk' => 'array',
      'addedValue' => 'array',
      'correlation' => 'array'
  ];
}
