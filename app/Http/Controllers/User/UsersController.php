<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UsersController extends Controller
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
        $cabinetsList=Auth::user()->cabinets;
        $cabinets=array();
        foreach ($cabinetsList as $cabinet)
        {
            $cabinets[$cabinet->id]=$cabinet->cabinet_name;
        }

        return view('user.users', compact('cabinets', 'cabinetsList'));
    }
}
