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
        $note->user_id = Auth::user()->id;
        $note->save();

        if(!is_null(Input::get('file'))){
            request()->file('image')->store('images');
            $image = new Image;
                // ensure every image has a different name
            $file_name = $request->file('image')->hashName();
            $image->path = $file_name;
            $image->save();
            }

// then in your view you reference the path like this:
//            <img src="{{ asset('public/images/' . $model->image) }}">
//            $note->images()->attach( $note->id);

        return back();
    }

    public function editeNote(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->title = $request->title;
        $note->body = $request->body;
        $note->save();

        return back();
    }

    public function deleteNote ($id)
    {
        $note = Note::findOrFail($id);
        $note->images()->detach();
        $note->delete();

        return back();
    }

}
