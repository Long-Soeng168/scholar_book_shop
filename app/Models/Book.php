<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $guarded = [];

    // public function publisher()
    // {
    //     return $this->belongsTo(User::class, 'publisher_id', 'id');
    // }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(BookSubCategory::class, 'sub_category_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(BookImage::class, 'book_id', 'id');
    }
}
