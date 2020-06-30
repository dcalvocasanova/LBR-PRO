<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'categories' => 'array'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'categories'
  ];
}
