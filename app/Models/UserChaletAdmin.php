<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserChaletAdmin extends Model
{
    use HasFactory, SoftDeletes;

    // START Relationship:[1] => [UserChaletAdmin Table] && [User Table]
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // END Relationship:[1] => [UserChaletAdmin Table] && [User Table]

    // START Relationship:[2] => [UserChaletAdmin Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[2] => [UserChaletAdmin Table] && [Chalet Table]

    // START Relationship:[3] => [UserChaletAdmin Table] && [UserChaletAdminMessage Table]
    public function userChaletAdminMessages()
    {
        return $this->hasMany(UserChaletAdminMessage::class, 'user_chalet_admins_id', 'id');
    }

    public function userChaletAdminMessageChalets()
    {
        return $this->belongsToMany(User::class, UserChaletAdminMessage::class, 'user_chalet_admins_id', 'users_id');
    }
    // END Relationship:[3] => [UserChaletAdmin Table] && [UserChaletAdminMessage Table]
}
