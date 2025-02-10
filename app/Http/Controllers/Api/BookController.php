<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookCategory;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 12;
        $search = $request->search;
        $categoryId = $request->categoryId;
        $priceFrom = $request->priceFrom;
        $priceTo = $request->priceTo;
        $yearFrom = $request->yearFrom;
        $yearTo = $request->yearTo;
        $authorId = $request->authorId;
        $publisherId = $request->publisherId;
        $subCategoryId = $request->subCategoryId;
        $randomOrder = $request->randomOrder ?? 0;
        $orderBy = $request->orderBy ?? 'id';
        $orderDir = strtolower($request->orderDir) === 'asc' ? 'asc' : 'desc'; // Ensure 'asc' or 'desc'

        $query = Book::query();

        if ($search) {
            $query->where(function ($sub_query) use ($search) {
                $sub_query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('isbn', 'LIKE', '%' . $search . '%')
                    ->orWhere('year', 'LIKE', '%' . $search . '%')
                    ->orWhere('short_description', 'LIKE', '%' . $search . '%');
            });
        }



        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($subCategoryId) {
            $query->where('sub_category_id', $subCategoryId);
        }

        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }

        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }

        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }

        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }

        if ($authorId) {
            $query->where('author_id', $authorId);
        }

        if ($publisherId) {
            $query->where('publisher_id', $publisherId);
        }

        if ($randomOrder == 1) {
            $query->inRandomOrder();
        } else {
            if ($orderBy == 'bestSelling') {
                $query->withCount('invoice_items')->orderBy('invoice_items_count', $orderDir);
            } elseif ($orderBy == 'totalView') {
                $query->orderBy('view_count', $orderDir);
            } else {
                $query->orderBy($orderBy, $orderDir);
            }
        }

        // Paginate results with the specified number per page
        $books = $query->where('status', 1)->paginate($perPage);

        return response()->json($books);
    }

    public function new_arrival(Request $request)
    {
        // First set of 10 books ordered by ID in descending order
        $first_set = Book::query()->orderBy('id', 'DESC')->where('status', 1)->limit(10)->get();

        // Second set of 10 books ordered by ID in descending order, offset by 10
        $second_set = Book::query()->orderBy('id', 'DESC')->offset(10)->where('status', 1)->limit(10)->get();

        return response()->json([
            'first_set' => $first_set,
            'second_set' => $second_set,
        ]);
    }

    public function new_products(Request $request)
    {
        // First set of 10 books ordered by ID in descending order
        $products = Book::query()->orderBy('id', 'DESC')->where('status', 1)->limit(12)->get();

        return response()->json($products);
    }

    public function category_with_products()
    {
        $categories = BookCategory::with('books')
            ->withCount('books')
            ->orderBy('books_count', 'desc')
            ->where('status', 1)
            ->take(10)
            ->get();

        // Limit books to 10 per category
        $categories->map(function ($category) {
            $category->setRelation('books', $category->books->take(10));
            return $category;
        });

        return response()->json($categories);
    }



    public function best_selling(Request $request)
    {
        $limit = $request->limit;
        // First set of 10 books ordered by ID in descending order
        $first_set = Book::query()->withCount('invoice_items')->orderBy('invoice_items_count', 'DESC')->orderBy('view_count', 'DESC')->where('status', 1)->limit($limit ?? 10)->get();

        // Second set of 10 books ordered by ID in descending order, offset by 10
        $second_set = Book::query()->withCount('invoice_items')->orderBy('invoice_items_count', 'DESC')->offset(10)->orderBy('view_count', 'DESC')->where('status', 1)->limit($limit ?? 10)->get();

        return response()->json([
            'first_set' => $first_set,
            'second_set' => $second_set,
        ]);
    }
    public function kid_books(Request $request)
    {
        $perPage = $request->perPage ?? 12;
        $search = $request->search;
        $categoryId = $request->categoryId;
        $priceFrom = $request->priceFrom;
        $priceTo = $request->priceTo;
        $yearFrom = $request->yearFrom;
        $yearTo = $request->yearTo;
        $authorId = $request->authorId;
        $publisherId = $request->publisherId;
        $subCategoryId = $request->subCategoryId;
        $randomOrder = $request->randomOrder ?? 0;
        $orderBy = $request->orderBy ?? 'id';
        $orderDir = strtolower($request->orderDir) === 'asc' ? 'asc' : 'desc'; // Ensure 'asc' or 'desc'

        $query = Book::query();

        if ($search) {
            $query->where(function ($sub_query) use ($search) {
                $sub_query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('isbn', 'LIKE', '%' . $search . '%')
                    ->orWhere('year', 'LIKE', '%' . $search . '%')
                    ->orWhere('short_description', 'LIKE', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($subCategoryId) {
            $query->where('sub_category_id', $subCategoryId);
        }

        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }

        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }

        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }

        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }

        if ($authorId) {
            $query->where('author_id', $authorId);
        }

        if ($publisherId) {
            $query->where('publisher_id', $publisherId);
        }

        if ($randomOrder == 1) {
            $query->inRandomOrder();
        } else {
            $query->orderBy($orderBy, $orderDir);
        }

        // Paginate results with the specified number per page
        $books = $query->where('category_id', 83)->where('status', 1)->paginate($perPage);

        return response()->json($books);
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
        $book =  Book::with('images', 'brand', 'category', 'subCategory')->where('status', 1)->findOrFail($id);
        $book->update([
            'view_count' => $book->view_count + 1,
        ]);
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
