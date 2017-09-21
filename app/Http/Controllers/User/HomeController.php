<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CabinetDrug;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HomeController extends Controller
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
    public function index()
    {
        if (Auth::user()->isAdmin()){
            return redirect('/admin/home');
        }
        $cabinets=Auth::user()->cabinets;

        $pastDateDrugs=new Collection;
        $finishedDrugs=new Collection;
        $today = Carbon::today();
        foreach($cabinets as $cabinet){
            $cabinetDrugs = CabinetDrug
                ::where('cabinet_id', $cabinet->id)
                ->where('expiration_date', '<', $today )
                ->select('cabinet_drugs.*')
                ->leftJoin('drugs', 'cabinet_drugs.ean', '=','drugs.ean')
                ->select('drugs.name')->get();
            $pastDateDrugs= $pastDateDrugs->merge($cabinetDrugs);

            $finishedCabinetDrugs = CabinetDrug
                ::where('cabinet_id', $cabinet->id)
                ->where('quantity', '<', 1 )
                ->select('cabinet_drugs.*')
                ->leftJoin('drugs', 'cabinet_drugs.ean', '=','drugs.ean')
                ->select('drugs.name')->get();
            $finishedDrugs= $finishedDrugs->merge($finishedCabinetDrugs);
        }



        return view('user.home', compact( 'pastDateDrugs', 'finishedDrugs'));
    }
}
