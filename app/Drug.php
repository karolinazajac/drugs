<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Drug extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ean', 'name', 'manufacturer', 'package', 'dose', 'character', 'basyl'
    ];
}
