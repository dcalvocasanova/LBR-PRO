<?php
namespace App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\Macroprocess as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Macroprocess extends Model
{
    //use Notifiable;
    //use HasRoles;

	  protected $guarded = [];

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.Macroprocess.'. $this->id;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'relatedToLevel','macroprocess', 'input', 'provider', 'activity','responsible', 'process', 'user','risk','indicator','project_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
      protected $hidden = [
          //'password', 'remember_token',
      ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//protected $casts = [
  //      'email_verified_at' => 'datetime', 'workingsince'=> 'date', 'birthday'=> 'date'
  //  ];

    /**
     * The Get dates format
     *
     * @return date (Y-m-d)
     */

    public function getBirthdayAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * The Get dates format
     *
     * @return date (Y-m-d)
     */

    public function getWorkingsinceAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
     
    }
}
