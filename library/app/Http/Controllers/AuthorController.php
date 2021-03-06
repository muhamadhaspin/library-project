<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.author');
    }

    public function api()
    {
        $authors = Author::all();
        foreach ($authors as $author) {
            $author->date = convertDate($author->created_at);
        }
        $datatables = datatables()->of($authors)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $validator = $request->validate([
            'name' => 'required|min:3|max:32',
            'email' => 'required|unique:authors',
            'phone_number' => 'required|unique:authors|min:12|max:15',
            'address' => 'required'
        ]);

        // Insert validated data into database
        Author::create($validator);

        return redirect('authors')->with('success', 'New author data has been Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        // Validation Data
        $validator = $request->validate([
            'name' => 'required|min:3|max:32',
            'email' => "required|unique:authors,email,{$author->id}",
            'phone_number' => "required|unique:authors,phone_number,{$author->id}|min:12|max:15",
            'address' => 'required'
        ]);

        // Insert validated data into database
        $author->update($validator);

        return redirect('authors')->with('success', 'Author data has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        // Delete data with specific ID
        $author->delete();

        return redirect('authors')->with('success', 'Author data has been Deleted');
    }
}
