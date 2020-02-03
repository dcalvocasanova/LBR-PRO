<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectStructure extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'levels' => 'array'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'project_id', 'levels'
  ];
}
