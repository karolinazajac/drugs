<?php
/**
 * Created by PhpStorm.
 * User: Karolina
 * Date: 2017-07-20
 * Time: 22:33
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'title', 'body', 'user_id'
];

    public function users()
{
    return $this->belongsToMany('App\User')->withPivot( 'main');
}

    public function cabinetDrugs()
{
    return $this->hasMany('App\CabinetDrug');
}
}