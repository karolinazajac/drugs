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

    /**
     * Relation to users table
     * @return $this
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot( 'main');
    }

    /**
     * Relation to cabinet_drugs table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cabinetDrugs()
    {
        return $this->hasMany('App\CabinetDrug');
    }
}
