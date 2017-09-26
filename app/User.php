<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function cabinets()
    {
        return $this->belongsToMany('App\Cabinet')->withPivot( 'main');
    }

    public function notes()
    {
        return $this->hasMany('App\Note')->latest();
    }
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->admin; // this looks for an admin column in your users table
    }

    /**
     * @param Cabinet $cabinet
     * @return bool
     */
    public function isCabinetAdmin( Cabinet $cabinet)
    {
        return $cabinet->user_id === $this->id;
    }
}
