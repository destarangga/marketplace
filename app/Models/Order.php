<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'menu_id',
        'quantity',
        'delivery_date',
        'bayar',
        'change',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class)->withTrashed();
    }

    public function getDeliveryDateAttribute($value)
    {
        return Carbon::parse($value); 
    }
}
