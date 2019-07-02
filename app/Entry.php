<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entry) {
            $entry->id = Uuid::uuid4();
        });
    }

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function children()
    {
        $this->hasMany('App\Entry', 'parent_id');
    }

    public function parent()
    {
        $this->hasMany('App\Entry', 'parent_id');
    }
}
