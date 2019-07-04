<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    /**
     * EntryController constructor.
     * Will check if user is logged in
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the entries in a paginated results.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries  = Entry::where('parent_id', null)->orderBy('created_at', 'desc')->paginate(15);
        return view('welcome')->with('entries', $entries);
    }


    /**
     * Will store the new entry
     *
     * If adding a parent who already has a parent
     * the parent will be set to that parent instead
     *
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
     * Display the specified entry with children.
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
     * Update the specified entry in storage.
     *
     * Includes check if current user is owner, throws 403 if not
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
     * Includes check if current user is owner, throws 403 if not
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
