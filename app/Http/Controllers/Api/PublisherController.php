<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function publishers(Request $request)
    {
        $search = $request->search;
        $role = $request->role;
        $perPage = $request->perPage ?? 200; // Set a default perPage value
        $orderBy = $request->orderBy ?? 'id';
        $orderDir = strtolower($request->orderDir) === 'asc' ? 'asc' : 'desc';

        $query = Publisher::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        if ($role) {
            $query->role($role);
        }

        $users = $query->orderBy($orderBy, $orderDir);

        $users = $users->paginate($perPage);

        return response()->json($users);
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
