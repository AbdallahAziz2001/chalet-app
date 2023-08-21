<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserChaletAdminMessage extends Model
{
    use HasFactory, SoftDeletes;

    // START Relationship:[1] => [UserChaletAdminMessage Table] && [User Table]
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // END Relationship:[1] => [UserChaletAdminMessage Table] && [User Table]

    // START Relationship:[2] => [UserChaletAdminMessage Table] && [UserChaletAdmin Table]
    public function userChaletAdmin()
    {
        return $this->belongsTo(UserChaletAdmin::class, 'user_chalet_admins_id', 'id');
    }
    // END Relationship:[2] => [UserChaletAdminMessage Table] && [UserChaletAdmin Table]
}
