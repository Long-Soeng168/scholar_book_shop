<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 12;
        $search = $request->search;
        $categoryId = $request->categoryId;
        $orderBy = $request->orderBy ?? 'id';
        $orderDir = strtolower($request->orderDir) === 'asc' ? 'asc' : 'desc'; // Ensure 'asc' or 'desc'

        $query = News::query();

        if ($search) {
            $query->where(function ($sub_query) use ($search) {
                $sub_query->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $query->where('news_category_id', $categoryId);
        }

        // Apply ordering
        $query->orderBy($orderBy, $orderDir);

        // Paginate results with the specified number per page
        $news = $query->paginate($perPage);

        return response()->json($news);
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
        $news = News::findOrFail($id);
        $news->update([
            'view_count' => $news->view_count + 1,
        ]);
        return response()->json($news);
    }
    public function categories()
    {
        $categories = NewsCategory::orderBy('name')->withCount('pages')->get();
        return response()->json($categories);
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
