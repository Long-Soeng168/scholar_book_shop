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
    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'last_edit_user_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(BookImage::class, 'book_id', 'id');
    }
    public function purchases()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'id');
    }
    public function adjustments()
    {
        return $this->hasMany(AdjustmentItem::class, 'product_id', 'id');
    }


}
