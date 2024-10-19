<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'price',
        'image_path',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
