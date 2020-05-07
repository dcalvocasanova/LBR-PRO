<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'project_id','task_id','procedure',
      'PHVA','frecuency','t_min', 't_avg',
      't_max','laborType'
  ];

  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'PHVA' => 'array'
  ];
}
