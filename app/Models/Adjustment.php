<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $table = 'adjustments';
    protected $guarded = [];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }
}
