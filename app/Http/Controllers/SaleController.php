<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
     // Display all ISBN Requests
     public function index()
     {
         return view('sales.index');
     }
     // Show the form for creating a new ISBN request
     public function create()
     {
         return view('sales.create');
     }

     public function show($id)
     {
         return view('sales.show', compact('id'));
     }

     public function edit($id)
     {
        return view('sales.edit', compact('id'));
     }

     public function categories()
    {
        return view('admin.sales.category');
    }

    public function sub_categories()
    {
        return view('admin.sales.sub_category');
    }


}
