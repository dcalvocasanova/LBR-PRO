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
      'task','id_project','id_product','task','relatedToLevel','allocator','type'
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
}
