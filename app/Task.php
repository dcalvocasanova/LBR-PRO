<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    /**
     * The attributes that are take them as JSON
     *
     * @var array
     */
    protected $casts = [
        'related_to' => 'array'
    ];
}
