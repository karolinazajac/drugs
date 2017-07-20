<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Note;
use Auth;

class DiaryController extends Controller
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
        return view('user.diary');
    }

    public function createNote(Request $request)
    {
        $note = new Note;
        $note->title = $request->title;
        $note->body = $request->body;
        $note->user_id = Auth::user()->id;;
        $note->save();
request()->file('image')->store('images');
        if(!is_null(Input::get('file'))){
//            $note->images()->attach($cabinet->id);
        }
        return back();
    }
}
