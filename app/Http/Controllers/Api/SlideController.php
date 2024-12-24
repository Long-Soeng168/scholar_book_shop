<?php

namespace App\Http\Controllers\Api;

use App\Models\Slide;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class SlideController extends Controller
{
    public function index(Request $request)
    {
        $position = $request->position;

        $query = Slide::query();

        if($position){
            $query->where('position', $position);
        }

        $slides = $query->orderBy('order_index', 'asc')->get();

        return response()->json($slides);
    }
}
