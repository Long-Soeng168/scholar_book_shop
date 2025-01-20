<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }
}
