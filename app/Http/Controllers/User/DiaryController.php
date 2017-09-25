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
//        if($notes->count() == 0 )
//        {
//            return view('user.diary', compact( 'notes'));
//        }

        return view('user.diary', compact( 'notes'));
    }

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
            $note->images()->attach( $image->id);
            }

// then in your view you reference the path like this:
//            <img src="{{ asset('public/images/' . $model->image) }}">
//            $note->images()->attach( $note->id);

        return back();
    }

    public function getNote( $id)
    {
        $note = Note::findOrFail($id);

        return view('user.note', compact( 'note'));
    }
//    public function getImage($filename)
//    {
//        $path = storage_path('public/' . $filename);
//
//        if (!File::exists($path)) {
//            abort(404);
//        }
//
//        $file = File::get($path);
//        $type = File::mimeType($path);
//
//        $response = Response::make($file, 200);
//        $response->header("Content-Type", $type);
//
//        return $response;
//    }

    public function deleteNote ($id)
    {
        $note = Note::findOrFail($id);
        $note->images()->detach();
        $note->delete();

        return back();
    }

}
