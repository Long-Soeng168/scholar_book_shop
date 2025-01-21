<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentItem extends Model
{
    use HasFactory;
    protected $table = 'adjustment_items';
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Book::class, 'product_id', 'id');
    }

}
