<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'task','project_id','product_id','task','relatedToLevel','relatedToUsers',
      'allocator','type','procedure','PHVA','frecuency','t_min', 't_avg','t_max',
      'quantity','competence','laborType','effort','risk','addedValue','correlation'
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
        $query->relatedToLevel = $query->relatedToLevel ?? 'default';
    });
  }

  /**
   * The attributes that are take them as JSON
   *
   * @var array
   */
  protected $casts = [
      'relatedToUsers' => 'array',
      'effort' => 'array',
      'risk' => 'array',
      'addedValue' => 'array',
      'correlation' => 'array',
      'PHVA' => 'array'
  ];
}
