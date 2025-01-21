<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdjustmentController extends Controller
{
     // Display all ISBN Requests
     public function index()
     {
         return view('adjustments.index');
     }

     // Show the form for creating a new ISBN request
     public function create()
     {
         return view('adjustments.create');
     }

     public function show($id)
     {
         return view('adjustments.show', compact('id'));
     }

     public function edit($id)
     {
        return view('adjustments.edit', compact('id'));
     }

     public function categories()
    {
        return view('admin.adjustments.category');
    }

    public function sub_categories()
    {
        return view('admin.adjustments.sub_category');
    }


}
