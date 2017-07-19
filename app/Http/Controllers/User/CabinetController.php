<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\CabinetDrug;
use App\Drug;
use App\Cabinet;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CabinetController extends Controller
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
        $cabinetsList=Auth::user()->cabinets;
        $cabinetDrugs=null;
        $mainCabinet='Twoja pierwsza apteczka';
        if($cabinetsList->count() == 0 )
        {
            return view('user.cabinet', compact( 'cabinetsList', 'mainCabinet', 'cabinetDrugs'));
        }
        if(is_null($id)){
            $defaultCabinet=Auth::user()->cabinets()->where('main', true)->first();
            $mainCabinet= (is_null($defaultCabinet))? Auth::user()->cabinets()->first() : $defaultCabinet;
            $id=$mainCabinet->id;
        }
        else {
            $mainCabinet= Cabinet::findOrFail($id);
        }

        if(CabinetDrug::where('cabinet_id', '=', $id)->count() > 0)
        {
            $cabinetDrugs = CabinetDrug
                ::where('cabinet_id', $id)
                ->select('cabinet_drugs.*')
                ->leftJoin('drugs', 'cabinet_drugs.ean', '=','drugs.ean')
                ->select('cabinet_drugs.*','drugs.name')->paginate(15);
        }


        return view('user.cabinet', compact( 'cabinetsList', 'mainCabinet', 'cabinetDrugs'));
    }

    public function getDrugs()
    {
        $data = array();
        $results = DB::table('drugs')->get();


        foreach ( $results as $result ):
            $data[] = [ 'id' => $result->ean, 'name' => $result->name, 'package'=>$result->package ];
        endforeach;

//        var_dump($data);
        return \Response::json($data);
    }

    public function createCabinet(Request $request)
    {
        $cabinet = new Cabinet;
        $cabinet->cabinet_name = $request->cabinet_name;
        $cabinet->user_id = Auth::user()->id;;
        $cabinet->save();
        Auth::user()->cabinets()->attach($cabinet->id);
        if(!is_null(Input::get('user_email'))){
            foreach (Input::get('user_email') as $key => $val) {
                $newUser=User::where('email',$val) -> first();
                $newUser->cabinets()->attach($cabinet->id);
            }
        }
        return back();
    }

    public function addDrug (Request $request)
    {
        $cabinetDrug = new CabinetDrug;
        $cabinetDrug->ean = $request->ean;
        $cabinetDrug->cabinet_id = $request->cabinetId;
        $cabinetDrug->quantity = $request->quantity;
        $cabinetDrug->expiration_date = Carbon::createFromFormat('d/m/Y', $request->date);
        $cabinetDrug->price = $request->price;
        $cabinetDrug->current_state = 1;
        $cabinetDrug->save();

        return back();
    }

    public function deleteDrug ($id)
    {
        $cabinetDrug = CabinetDrug::findOrFail($id);

        $cabinetDrug->delete();

        return back();
    }

    public function editDrug (Request $request, $id)
    {
        $cabinetDrug = CabinetDrug::findOrFail($id);
        $cabinetDrug->quantity = $request->input('updatedQuantity');
        $cabinetDrug->save();
        return back();
    }

    public function deleteCabinetUser ($cabinetId, $userId)
    {
        $user = User::findOrFail($userId);

        $user->cabinets()->detach($cabinetId);

        return back();
    }

    public function deleteCabinet ($id)
    {
        $cabinet = Cabinet::findOrFail($id);
        $cabinet->users()->detach();
        $cabinet->delete();

        return back();
    }

    public function addUser(Request $request, $cabinetId)
    {
        dd(Input::get('newUser'));
        if(!is_null(Input::get('newUser'))){

                $newUser=User::where('email',Input::get('newUser')) -> first();
                $newUser->cabinets()->attach($cabinetId);
        }
        return back();
    }
}
