<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerting extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'title', 'body','sender','type','status','receiver','reasons','read_at'
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
          $query->reasons = $query->reasons ?? 'Pending';
      });
      static::creating(function ($query) {
          $query->status = $query->status ?? 'Pending';
      });
  }
}
