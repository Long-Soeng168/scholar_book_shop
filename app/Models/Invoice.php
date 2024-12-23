<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
