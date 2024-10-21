<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($menu) {
    //         // Hapus relasi dengan menu ini, tetapi tetap simpan riwayat order
    //         $menu->orders()->each(function ($order) {
    //             $order->menu_id = null; // Set menu_id ke null atau biarkan
    //             $order->save();
    //         });
    //     });
    // }
    public function merchant()
    {
        return $this->belongsTo(User::class);
    }
}
