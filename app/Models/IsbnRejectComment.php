<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsbnRejectComment extends Model
{
    use HasFactory;
    protected $table = 'isbn_rejects_comments';
    protected $guarded = [];

    public function Isbn(){
        return $this->belongsTo(IsbnRequest::class, 'isbn_id', 'id');
    }
}
