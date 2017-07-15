<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CabinetDrug extends Model
{
    protected $table = 'cabinet_drugs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ean', 'cabinet_id', 'quantity', 'expiration_date', 'current_state', 'price'
    ];

    public function cabinet()
    {
        return $this->belongsTo('App\User');
    }
    public function drug()
    {
        return $this->belongsTo('App\Drugs');
    }
    public function drugConsumption()
    {
        return $this->hasMany('App\DrugConsumptions');
    }
}
