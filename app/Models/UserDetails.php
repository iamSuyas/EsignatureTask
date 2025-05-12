<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    //
    protected $fillable = [
        'user_id',
        'company_name',
        'other_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
