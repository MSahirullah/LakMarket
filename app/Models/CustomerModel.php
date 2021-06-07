<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\GnDivision;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'url',
        'email',
        'mobileNo',
        'dob',
        'gender',
        'is_verified',
        'address',
        'postal_code',
        'city_id',
        'district_id',
        'location_la',
        'location_lo',
        'password',
        'blacklisted',
        'delete_status',
        'status',
        'last_logged_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
