<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CabinetDrug;
use App\Cabinet;
use Auth;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        $cabinetCost=null;
        $drugUsage=null;
        $cabinetsList=Auth::user()->cabinets;
        $mainCabinet='Twoja pierwsza apteczka';
        if($cabinetsList->count() == 0 )
        {
            return view('user.stats', compact( 'cabinetsList', 'mainCabinet', 'cabinetCost', 'drugUsage'));
        }
        if(is_null($id)){
            $defaultCabinet=Auth::user()->cabinets()->where('main', true)->first();
            $mainCabinet= (is_null($defaultCabinet))? Auth::user()->cabinets()->first() : $defaultCabinet;
            $id=$mainCabinet->id;
        }
        else {
            $mainCabinet= Cabinet::findOrFail($id);
        }

        $cabinetCost = CabinetDrug::lastSixMonths($id)
            ->selectRaw('month(created_at)as month, sum(price) as price ')
            ->groupBy('month')
            ->pluck('price', 'month');
        $drugUsage = CabinetDrug::lastSixMonths($id)
            ->selectRaw('month(created_at)as month, sum(quantity) as quantity ')
            ->groupBy('month')
            ->pluck('quantity', 'month');
        return view('user.stats', compact( 'cabinetsList', 'mainCabinet', 'cabinetCost', 'drugUsage'));
    }

    public function getData($id){
        $cabinetCost = CabinetDrug::lastSixMonths($id)
            ->selectRaw('month(created_at)as month, sum(price) as price ')
            ->groupBy('month')
            ->pluck('price', 'month');
    }
}