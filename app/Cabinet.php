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

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function cabinetDrugs()
    {
        return $this->hasMany('App\CabinetDrug');
    }

}
