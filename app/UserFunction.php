<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFunction extends Model
{
  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'user_functions' => 'array'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'user_functions'
  ];

}
