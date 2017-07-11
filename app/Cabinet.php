<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'cabinet_name', 'user_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function cabinetDrugs()
    {
        return $this->hasMany('App\CabinetDrug');
    }

}
