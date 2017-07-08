<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
    public function index()
    {
        return view('user.cabinet');
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
}
