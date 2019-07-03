<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries  = Entry::where('parent_id', null)->orderBy('created_at', 'desc')->paginate(15);
        return view('welcome')->with('entries', $entries);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'sometimes|required|exists:entries,id'
        ]);

        $parent_id = $request->get('parent_id');
        $entry = new Entry();
        $entry->content = $request->get('content');

        if($parent_id) {
            $parent = Entry::where('id', $parent_id)->firstOrFail();
            if($parent->parent_id) {
                $parent_id = $parent->parent_id;
            }
            $entry->parent_id = $parent_id;
            $entry->save();
            return  redirect(route('entry.show', ['entry' => $parent]));
        }
        $entry->save();
        return redirect(route('index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $entries = $entry->children()->orderBy('created_at', 'desc')->paginate(15);
        return view('entries.show')->with('entries', $entries)->with('parent', $entry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        $request->validate([
            'content' => 'required',
        ]);

        if (Auth::id() === $entry->user_id) {
            $entry->content = $request->get('content');
            $entry->save();
            return redirect(route('entry.show',['entry' => $entry]));
        }
        abort(403, 'Access denied');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        if (Auth::id() === $entry->user_id) {
            $entry->delete();
            return redirect(route('index'));
        }
        abort(403, 'Access denied');
    }
}
