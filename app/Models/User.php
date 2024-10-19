<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'email',
        'password',
        'role',
        'alamat',       
        'no_telepon',   
        'deskripsi',    
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Method to check if the user is a merchant.
     *
     * @return bool
     */
    public function isMerchant()
    {
        return $this->role === 'merchant';
    }

    /**
     * Method to check if the user is a customer.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
