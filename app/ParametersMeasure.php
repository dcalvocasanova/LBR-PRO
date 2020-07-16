<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ParametersMeasure extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'project_id','user_id','category_id','measure','variable','fecha'
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
	


public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
