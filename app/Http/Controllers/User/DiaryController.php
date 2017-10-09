<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Note;
use App\Image;
use Auth;
use Illuminate\Support\Facades\Storage;

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
        $notes=Auth::user()->notes;

        return view('user.diary', compact( 'notes'));
    }

    /**
     * Create new note
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createNote(Request $request)
    {
        $note = new Note;
        $note->title = $request->title;
        $note->body = $request->body;
        $note->user_id = Auth::user()->id;
        $note->save();

        if(!is_null( request()->file('image'))){
            request()->file('image')->store('public');

            $image = new Image;
                // ensure every image has a different name
            $file_name = $request->file('image')->hashName();
            $image->path = $file_name;
            $image->save();
            request()->file('image')->move(public_path("/img"),  $file_name);
            $note->images()->attach( $image->id);
            }

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNote( $id)
    {
        $note = Note::findOrFail($id);

        return view('user.note', compact( 'note'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteNote ($id)
    {
        $note = Note::findOrFail($id);
        $note->images()->detach();
        $note->delete();

        return back();
    }

}
