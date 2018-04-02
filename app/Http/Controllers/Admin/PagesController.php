<?php

namespace App\Http\Controllers\Admin;

use App\Http\GoogleDriveUtilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Page;

class PagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $page_validation = [
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'title' => 'required',
        'description' => 'required',
        'content' => 'required',
    ];

    public function index()
    {
        return view('admin.pages.index', [
            'pages' => Page::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->page_validation);

        $page = new Page();
        $page->title = $request->title;
        $page->description = $request->description;
        $page->content = $request->input('content');
        $page->save();

        return redirect('/admin/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.show', [
            'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', ['page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->page_validation);

        Page::find($id)->update($request->all());
        

        return redirect('/admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::destroy($id);
        Session::flash('flash_message', "Delete Successful!");

        return redirect('/admin/pages');
    }
}
