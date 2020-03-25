<?php
namespace App;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

	  protected $guarded = [];

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'. $this->id;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'identification', 'type', 'email','salary', 'position', 'job','birthday','workingsince', 'education','workday', 'avatar', 'gender','ethnic','sex','password','relatedProjects'
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
        'email_verified_at' => 'datetime',
        'workingsince'=> 'date',
        'birthday'=> 'date',
        'relatedProjects' => 'array'
    ];

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
        static::creating(function ($query) {
            $query->avatar = $query->avatar ?? 'default.png';
        });
        static::creating(function ($query) {
            $query->type = $query->type ?? 'web';
        });
        static::creating(function ($query) {
            $query->salary = $query->salary ?? '0';
        });
        static::creating(function ($query) {
            $query->position = $query->position ?? 'Usuario de sistema';
        });
        static::creating(function ($query) {
            $query->job = $query->job ?? 'N/A';
        });
        static::creating(function ($query) {
            $query->workingsince = $query->workingsince ?? now();
        });
        static::creating(function ($query) {
            $query->birthday = $query->birthday ?? now();
        });
        static::creating(function ($query) {
            $query->education = $query->education ?? 'N/A';
        });
        static::creating(function ($query) {
            $query->workday = $query->workday ?? '0';
        });
        static::creating(function ($query) {
            $query->gender = $query->gender ?? 'N/A';
        });
        static::creating(function ($query) {
            $query->ethnic = $query->ethnic ?? 'N/A';
        });
        static::creating(function ($query) {
            $query->sex = $query->sex ?? 'N/A';
        });
        static::creating(function ($query) {
            $query->relatedProjects = $query->relatedProjects ?? '';
        });
        static::creating(function ($query) {
            $query->password = $query->password ?? Str::random(15);
        });
    }
}
