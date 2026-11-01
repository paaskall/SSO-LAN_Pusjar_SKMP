<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAppAccess extends Model
{
    use HasFactory;

    protected $table = 'user_app_access';

    protected $fillable = [
        'user_id',
        'app_slug',
        'role_in_app',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}