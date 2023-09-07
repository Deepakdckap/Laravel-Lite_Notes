<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashedNoteController extends Controller
{
    public function index()
    {
        // return 'Trash';
        // this onlyTrashed() fetches the soft deleted notes
        $notes = Note::whereBelongsTo(Auth::user())->onlyTrashed()->latest('updated_at')->paginate(5);
        return view('notes.index')->with('notes',$notes);
    }

    public function show(Note $note)
    {
        // before dump this make sure that u are changed the route to fetch the soft deleted note by withTrashed() keyword
         // dd($note);

        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }
        return view('notes.show')->with('note',$note);
    }

    // restore the trashed note
    public function update(Note $note)
    {
        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }

        $note->restore();

        return to_route('notes.show',$note)->with('success','Note Restored Successfully!!!');
    }

    // delete note permanently
    public function destroy(Note $note)
    {
        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }

        $note->forceDelete();

        return to_route('trashed.index')->with('success','Note Deleted Permanently!');
    }
}
