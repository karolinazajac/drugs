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

    /**
     * Relation for cabinet_drugs table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabinetDrugs()
    {
        return $this->belongsTo('App\CabinetDrug');
    }

    /**
     * Filter data from last six month
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeLastSixMonths($query, $id)
    {
        return $query->where('user_id', $id)->where('created_at','>',  Carbon::now()->subMonths(6) );
    }
}
