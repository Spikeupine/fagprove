<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class Entry extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entry) {
            $entry->id = Uuid::uuid4();
            $entry->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function children()
    {
        return $this->hasMany('App\Entry', 'parent_id');
    }

    public function parent()
    {
        return $this->hasMany('App\Entry', 'parent_id');
    }
}
