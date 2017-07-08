<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Drug;
use Excel;

class DrugsController extends Controller
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
        return view('admin.drugs');
    }

    /**
     * Import file into database Code
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importExcel(Request $request)
    {

        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){

                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        foreach ($value as $v) {
                            $insert[] = ['ean' => $v['ean'], 'name' => $v['name'], 'manufacturer' => $v['manufacturer'], 'package' => $v['package'], 'dose' => $v['dose'], 'character' => $v['character'], 'basyl' => $v['basyl']];
                        }
                    }
                }


                if(!empty($insert)){
                    Drug::insert($insert);
                    return back()->with('success','Rekordy zostały pomyślnie dodane do tabeli :)');
                }

            }

        }

        return back()->with('error','Sprawdź importowany plik, coś jest z nim nie tak :(');
    }
}
