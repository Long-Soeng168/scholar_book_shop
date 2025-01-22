<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view setting', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:create setting', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update setting', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete setting', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.menus.index');
    }

    public function contact()
    {
        $contact = Contact::first();
        return view('admin.menus.contact',[
            'contact' => $contact,
        ]);
    }
    public function about()
    {
        $about = About::first();
        return view('admin.menus.about',[
            'about' => $about,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', [
            'menu' => $menu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
