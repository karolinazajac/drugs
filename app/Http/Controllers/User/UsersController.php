<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

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
     * Show the users dashboard.
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

    /**
     * Edit logged user data
     * Edytuj dane użytkownika
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('editName');
        $user->email = $request->input('editEmail');
        $user->save();
        return back();
    }
}
