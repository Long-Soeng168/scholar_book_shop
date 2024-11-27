<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('perPage', 4);  // Default to 12 items per page
        $search = $request->get('search');
        $orderBy = $request->get('orderBy', 'id');      // Default ordering by 'id'
        $orderDir = strtolower($request->get('orderDir', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Create query on Promotion model
        $query = Promotion::query();

        // Apply search filter on 'name' and 'description' if provided
        if ($search) {
            $query->where(function ($sub_query) use ($search) {
                $sub_query->where('name', 'LIKE', '%' . $search . '%')
                          ->orWhere('short_description', 'LIKE', '%' . $search . '%');
            });
        }

        // Order by specified column and direction
        $query->orderBy($orderBy, $orderDir);

        // Paginate results with the specified number per page
        $promotions = $query->paginate($perPage);

        return response()->json($promotions);
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
