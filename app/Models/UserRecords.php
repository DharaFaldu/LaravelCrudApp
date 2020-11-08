<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'date_of_joining', 'date_of_leaving', 'image', 'is_deleted'
    ];
}
