<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugConsumption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cabinet_drugs_id', 'quantity', 'amount'
    ];

    public function cabinetDrugs()
    {
        return $this->belongsTo('App\CabinetDrug');
    }
}
