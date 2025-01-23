<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $withSub = $request->input('withSub', 0);
        $orderBy = $request->input('orderBy', 'order_index');
        $orderDir = strtolower($request->input('orderDir', 'asc')) === 'desc' ? 'desc' : 'asc'; // Ensure 'asc' or 'desc'

        // Base query for book categories
        $query = BookCategory::query()
            ->orderBy($orderBy, $orderDir)
            ->withCount('books'); // Get the total count of books for each category

        // Conditionally load sub-categories and books
        if ($withSub == 1) {
            $query->with(['subCategories' => function ($subQuery) {
                $subQuery->withCount('books') // Count books in each sub-category
                    ->with(['books' => function ($bookQuery) {
                        $bookQuery->limit(10); // Optional: Limit books per sub-category
                    }]);
            }]);
        }else if($withSub == 2){
            $query->with('subCategories');
        }

        // Apply limit if provided
        if ($limit) {
            $query->limit($limit);
        }

        $categories = $query->where('status', 1)->get();

        return response()->json($categories);
    }


    public function getCategoryWithMostBooks()
    {
        $category = BookCategory::withCount('books')
            ->with(['books' => function ($query) {
                $query->limit(5); // Limit books to 4
            }])
            ->orderBy('books_count', 'desc')
            ->where('status', 1)
            ->first(); // Get the category with the most books

        return response()->json($category);
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
        //
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
