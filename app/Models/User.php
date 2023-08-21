<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = ['password',];

    protected $hidden = ['password',];

    protected $casts = ['birthday' => 'date'];

    // START Relationship:[1] => [User Table] && [UserBalanceDetail Table]
    public function userBalanceDetails()
    {
        return $this->hasMany(UserBalanceDetail::class, 'users_id', 'id');
    }
    // END Relationship:[1] => [User Table] && [UserBalanceDetail Table]

    // START Relationship:[2] => [User Table] && [UserChaletStatus Table]
    public function userChaletStatuses()
    {
        return $this->hasMany(UserChaletStatus::class, 'users_id', 'id');
    }

    public function userChaletStatusChalets()
    {
        return $this->belongsToMany(Chalet::class, UserChaletStatus::class, 'users_id', 'chalets_id');
    }
    // END Relationship:[2] => [User Table] && [UserChaletStatus Table]

    // START Relationship:[3] => [User Table] && [UserChaletAdmin Table]
    public function userChaletAdmins()
    {
        return $this->hasMany(UserChaletAdmin::class, 'users_id', 'id');
    }

    public function userChaletAdminChalets()
    {
        return $this->belongsToMany(Chalet::class, UserChaletAdmin::class, 'users_id', 'chalets_id');
    }
    // END Relationship:[3] => [User Table] && [UserChaletAdmin Table]

    // START Relationship:[4] => [User Table] && [UserChaletAdminMessage Table]
    public function userChaletAdminMessages()
    {
        return $this->hasMany(UserChaletAdminMessage::class, 'users_id', 'id');
    }

    public function userChaletAdminMessageChalets()
    {
        return $this->belongsToMany(UserChaletAdmin::class, UserChaletAdminMessage::class, 'users_id', 'user_chalet_admins_id');
    }
    // END Relationship:[4] => [User Table] && [UserChaletAdminMessage Table]

    // START Relationship:[5] => [User Table] && [ChaletAutomaticReservation Table]
    public function chaletAutomaticReservations()
    {
        return $this->hasMany(ChaletAutomaticReservation::class, 'users_id', 'id');
    }
    // END Relationship:[5] => [User Table] && [ChaletAutomaticReservation Table]

    // START Relationship:[5] => [User Table] && [ChaletAutomaticReservation Table]
    public function routeNotificationForTweetSms()
    {
        return $this->mobile;
    }
    // END Relationship:[5] => [User Table] && [ChaletAutomaticReservation Table]
}
