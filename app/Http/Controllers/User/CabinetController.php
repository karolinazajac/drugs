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
use App\DrugConsumption;


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
        //get list of user's cabinets
        //wybierz listę apteczek należącą do zalogowanego użytkownika
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

    /**
     * Get list of drugs for dropdown form
     * Wybierz liste leków dla formularza
     * @return mixed
     */
    public function getDrugs()
    {
        $data = array();
        $results = DB::table('drugs')->get();

        foreach ( $results as $result ):
            $data[] = [ 'id' => $result->ean, 'name' => $result->name, 'package'=>$result->package ];
        endforeach;

        return \Response::json($data);
    }

    /**
     * Create new user cabinet
     * Stwórz nowa apteczkę dla użytkownika
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createCabinet(Request $request)
    {
        $cabinet = new Cabinet;
        $cabinet->cabinet_name = $request->cabinet_name;
        $cabinet->user_id = Auth::user()->id;
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

    /**
     * Add drug to cabinet
     * Dodaj lek do apteczki
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Delete drug from cabinet
     * Usuń lek z apteczki
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDrug ($id)
    {
        $cabinetDrug = CabinetDrug::findOrFail($id);

        $cabinetDrug->delete();

        return back();
    }

    /**
     * Edit amount of drug in cabinet
     * Edytuj ilość leku w apteczce
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editDrug (Request $request, $id)
    {
        $cabinetDrug = CabinetDrug::findOrFail($id);
        $initialQuantity= $cabinetDrug->quantity;
        $newQuantity= $request->input('updatedQuantity');
        if($initialQuantity > $newQuantity ){
            $consumption = new DrugConsumption;
            $consumption->user_id = Auth::user()->id;
            $consumption->cabinet_drugs_id = $id;
            $consumption->amount = $initialQuantity - $newQuantity;
            $consumption->save();
        }
        $cabinetDrug->quantity = $request->input('updatedQuantity');
        $cabinetDrug->save();
        return back();
    }

    /**
     * Delete selected cabinet user
     * Usuń uzytkownika apteczki
     * @param $cabinetId
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCabinetUser ($cabinetId, $userId)
    {
        $user = User::findOrFail($userId);

        $user->cabinets()->detach($cabinetId);

        return back();
    }

    /**
     * Delete cabinet
     * Usuń apteczkę
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCabinet ($id)
    {
        $cabinet = Cabinet::findOrFail($id);
        $cabinet->users()->detach();
        $cabinet->delete();

        return back();
    }

    /**
     * Add new user to cabinet
     * dodaj nowego użytkownika do istniejacej apteczki
     * @param Request $request
     * @param $cabinetId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addUser(Request $request, $cabinetId)
    {
        if(!is_null(Input::get('newUser'))){

                $newUser=User::where('email',Input::get('newUser')) -> first();
            if($newUser){
                $newUser->cabinets()->attach($cabinetId);
            }
             else{
                return back()->with('status', 'Użytkownik o takim adresie email nie założył konta w naszej aplikacji, więc nie możesz dodać go do swojej apteczki.');
             }
        }
        return back();
    }
}
