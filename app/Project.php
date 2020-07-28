<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
      'name','logo_project','logo_sponsor','logo_auxiliar', 'latitude','longitude','economic_activity', 'terms_connditions'      
  ];
}
