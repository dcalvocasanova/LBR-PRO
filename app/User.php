<?php
namespace App;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

	  protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'identification', 'type', 'email','salary', 'position', 'job','birthday','workingsince', 'education','workday', 'avatar', 'gender','ethnic','sex','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
      protected $hidden = [
          'password', 'remember_token',
      ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', 'workingsince'=> 'date', 'birthday'=> 'date'
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
            $query->avatar = $query->avatar ?? 'default.png';
        });
    }

}
