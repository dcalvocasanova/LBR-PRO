<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedGoals extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'project_id','releatedLevel','parentGoal','currentGoals'
  ];

  /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();
    static::creating(function ($query) {
     //   $query->relatedToLevel = $query->relatedToLevel ?? 'default';
    });
  }

  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
     
  ];
}
