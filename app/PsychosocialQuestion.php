<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PsychosocialQuestion extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'question'
  ];
}
