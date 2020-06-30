<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskParameter extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'risk_id', 'related_to'
  ];
}
