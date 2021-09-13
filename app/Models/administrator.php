<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrator extends Model
{
    use HasFactory;
    protected $table = 'administrators';
    protected $fillable = ['full_name', 'profile_photo', 'email', 'phone_number', 'date_of_birth', 'address', 'password', 'role', 'Linkedin', 'blacklisted', 'delete_status'];
}
