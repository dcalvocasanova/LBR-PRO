<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PsychosocialVariable extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'related_to_questions' => 'array'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'variable','related_to_questions'
  ];
}
