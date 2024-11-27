<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsbnRequest extends Model
{
    use HasFactory;
    protected $table = 'isbn';
    protected $guarded = [];

    public function publisher(){
        return $this->belongsTo(User::class, 'publisher_id', 'id');
    }

    public function category(){
        return $this->belongsTo(BookCategory::class, 'category_id', 'id');
    }

    public function subCategory(){
        return $this->belongsTo(BookSubCategory::class, 'sub_category_id', 'id');
    }

    public function comments(){
        return $this->hasMany(IsbnRejectComment::class, 'isbn_id', 'id');
    }
}
