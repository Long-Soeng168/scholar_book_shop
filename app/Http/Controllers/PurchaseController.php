<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
     // Display all ISBN Requests
     public function index()
     {
         return view('purchases.index');
     }

     // Show the form for creating a new ISBN request
     public function create()
     {
         return view('purchases.create');
     }

     public function show($id)
     {
         return view('purchases.show', compact('id'));
     }

     public function edit($id)
     {
        return view('purchases.edit', compact('id'));
     }

     public function categories()
    {
        return view('admin.purchases.category');
    }

    public function sub_categories()
    {
        return view('admin.purchases.sub_category');
    }


}
