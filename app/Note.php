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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
{
    return $this->belongsToMany( 'App\Image');
}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
{
    return $this->belongsTo('App\User');
}
}