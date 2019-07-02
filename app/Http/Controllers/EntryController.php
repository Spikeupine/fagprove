<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
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
            $parent = Entry::where('parent_id', $parent_id)->firstOrFail();
            if($parent->parent_id) {
                $parent_id = $parent->parent_id;
            }
            $entry->content = $parent_id;
            $entry->save();
            return $this->show($entry);
        }
        $entry->save();
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        //
    }
}
