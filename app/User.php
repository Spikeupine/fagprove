<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * boot function from https://dev.to/wilburpowery/easily-use-uuids-in-laravel-45be
     * Sets id of user to a uuid on creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id = Uuid::uuid4();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'isAdmin'
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Entries()
    {
        return $this->hasMany('App\Entry');
    }
}
