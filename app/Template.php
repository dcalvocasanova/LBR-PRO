<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'stencil' => 'array'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'description', 'type', 'stencil'
  ];
}
