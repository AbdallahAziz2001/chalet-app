<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChaletStatus extends Model
{
    use HasFactory;

    // START Relationship:[1] => [UserChaletStatus Table] && [User Table]
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // END Relationship:[1] => [UserChaletStatus Table] && [User Table]

    // START Relationship:[2] => [UserChaletStatus Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[2] => [UserChaletStatus Table] && [Chalet Table]
}
