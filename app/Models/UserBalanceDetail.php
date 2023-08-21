<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalanceDetail extends Model
{
    use HasFactory;

    // START Relationship:[1] => [UserBalanceDetail Table] && [User Table]
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // END Relationship:[1] => [UserBalanceDetail Table] && [User Table]
}
