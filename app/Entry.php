<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class Entry extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * When a new entry is created a new uuid is set as the id
     * Also sets id of current user to owner
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entry) {
            $entry->id = Uuid::uuid4();
            $entry->user_id = Auth::id();
        });
    }

    /**
     * Returns eloquent query of owner of an entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Returns eloquent query of children of an entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Entry', 'parent_id');
    }

    /**
     * Returns eloquent query of parent of an entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parent()
    {
        return $this->hasMany('App\Entry', 'parent_id');
    }
}
