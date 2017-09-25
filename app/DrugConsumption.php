<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function scopeLastSixMonths($query, $id)
    {
        return $query->where('user_id', $id)->where('created_at','>',  Carbon::now()->subMonths(6) );
    }
}
