<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookSubCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'sub_categories';

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id', 'id');
    }
    
    public function books()
    {
        return $this->hasMany(Book::class, 'sub_category_id', 'id');
    }
}
