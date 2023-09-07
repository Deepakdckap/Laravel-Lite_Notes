<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // two ways of access user id
        // $userId = Auth::user()->id;
        // $userId = Auth::id();
        // $notes = Note::where('user_id',$userId)->get();
        // ==========
        // $notes = Note::where('user_id',Auth::id())->latest('updated_at')->paginate(5);
    // below code works by relational method
        // $notes = Auth::user()->notes()->latest('updated_at')->paginate(5);
    // whereBelongsTo() keyword
        $notes = Note::whereBelongsTo(Auth::user())->latest('updated_at')->paginate(5);
        // return view('notes.index',compact('notes'));

        // $notes->each(function ($note){
        //     dump($note->title);
        // });

        //  To display all notes in Index
        return view('notes.index')->with('notes',$notes);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required'
        ]);

        // inserting by equloent method
        /*
        $note = new Note([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'text' => $request->text
        ]);
        $note->save();
        */
// -------------
        // create and save using inbuilt method
        // Note::create([
        //     'uuid' => Str::uuid(),
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'text' => $request->text
        // ]);
// -------------------
        // create and save by using relational method
        // in this method we are not inserting the user id (Forigen Key) manually.
       Auth::user()->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'text' => $request->text
        ]);

        // this to_route() method is new imported in Laravel 9
        return to_route('notes.index');
        // -----------------------
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ----------
    /*
    public function show($uuid)
    {
        // this firstOrFail() can be fetched any id in URL
        // $note = Note::where('user_id',$id)->firstOrFail();
        // -------
        // you need to check auth id and post id
        $note = Note::where('uuid',$uuid)->where('user_id', Auth::id())->firstOrFail();
        return view('notes.show')->with('note',$note);
    }
    */
    // ----------
    // Rote Model Binding
    public function show(Note $note)
    {
        // Laravel 9 doc Gateways Authraztion
        // other user should not access other user uuid
        // if ($note->user_id != Auth::id() ) {
            //  below  if condition code works as a relational method
        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }
        return view('notes.show')->with('note',$note);
    }
// ----
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }
        return view('notes.edit')->with('note',$note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        // dd($request);
        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required'
        ]);

        $note->update([
            'title' => $request->title,
            'text' => $request->text
        ]);

        return to_route('notes.show', $note)->with('success','Note Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if (!$note->user->is(Auth::user()) ) {
            return abort(403);
        }

        $note->delete();

        return to_route('notes.index')->with('success','Note Moved to Trash!!');
    }
}
