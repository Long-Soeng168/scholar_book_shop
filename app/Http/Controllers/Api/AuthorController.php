<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 200;
        $search = $request->search; 
        $randomOrder = $request->randomOrder ?? 0;
        $orderBy = $request->orderBy ?? 'id';
        $orderDir = strtolower($request->orderDir) === 'asc' ? 'asc' : 'desc'; // Ensure 'asc' or 'desc'

        $query = Author::query();

        if ($search) {
            $query->where(function ($sub_query) use ($search) {
                $sub_query->where('name', 'LIKE', '%' . $search . '%');
            });
        }
 

        if ($randomOrder == 1) {
            $query->inRandomOrder();
        } else {
            $query->orderBy($orderBy, $orderDir);
        }

        // Apply ordering

        // Paginate results with the specified number per page
        $authors = $query->paginate($perPage);

        return response()->json($authors);
    }

    public function new_arrival(Request $request)
    {
        // First set of 10 books ordered by ID in descending order
        $first_set = Book::query()->orderBy('id', 'DESC')->limit(10)->get();

        // Second set of 10 books ordered by ID in descending order, offset by 10
        $second_set = Book::query()->orderBy('id', 'DESC')->offset(10)->limit(10)->get();

        return response()->json([
            'first_set' => $first_set,
            'second_set' => $second_set,
        ]);
    }

    public function best_selling(Request $request)
    {
        $limit = $request->limit;
        // First set of 10 books ordered by ID in descending order
        $first_set = Book::query()->inRandomOrder()->limit($limit ?? 10)->get();

        // Second set of 10 books ordered by ID in descending order, offset by 10
        $second_set = Book::query()->inRandomOrder()->offset(10)->limit($limit ?? 10)->get();

        return response()->json([
            'first_set' => $first_set,
            'second_set' => $second_set,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $book =  Book::with('images', 'author', 'publisher', 'category', 'subCategory')->find($id);
        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
