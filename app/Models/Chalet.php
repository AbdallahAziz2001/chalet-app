<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chalet extends Model
{
    use HasFactory;

    // START Relationship:[1] => [Chalet Table] && [ChaletImage Table]
    public function chaletImages()
    {
        return $this->hasMany(ChaletImage::class, 'chalets_id', 'id');
    }
    // END Relationship:[1] => [Chalet Table] && [ChaletImage Table]

    // START Relationship:[2] => [Chalet Table] && [ChaletPolicy Table]
    public function chaletPolicies()
    {
        return $this->hasMany(ChaletPolicy::class, 'chalets_id', 'id');
    }
    // END Relationship:[2] => [Chalet Table] && [ChaletPolicy Table]

    // START Relationship:[3] => [Chalet Table] && [ChaletTerm Table]
    public function chaletTerms()
    {
        return $this->hasMany(ChaletTerm::class, 'chalets_id', 'id');
    }
    // END Relationship:[3] => [Chalet Table] && [ChaletTerm Table]

    // START Relationship:[4] => [Chalet Table] && [ChaletPrice Table]
    public function chaletPrices()
    {
        return $this->hasMany(ChaletPrice::class, 'chalets_id', 'id');
    }
    // END Relationship:[4] => [Chalet Table] && [ChaletPrice Table]

    // START Relationship:[5] => [Chalet Table] && [ChaletMainFacility Table]
    public function chaletMainFacilities()
    {
        return $this->hasMany(ChaletMainFacility::class, 'chalets_id', 'id');
    }
    // END Relationship:[5] => [Chalet Table] && [ChaletMainFacility Table]

    // START Relationship:[6] => [Chalet Table] && [UserChaletStatus Table]
    public function userChaletStatuses()
    {
        return $this->hasMany(UserChaletStatus::class, 'chalets_id', 'id');
    }

    public function userChaletStatusUsers()
    {
        return $this->belongsToMany(User::class, UserChaletStatus::class, 'chalets_id', 'users_id');
    }
    // END Relationship:[6] => [Chalet Table] && [UserChaletStatus Table]

    // START Relationship:[7] => [Chalet Table] && [UserChaletAdmin Table]
    public function userChaletAdmins()
    {
        return $this->hasMany(UserChaletAdmin::class, 'chalets_id', 'id');
    }

    public function userChaletAdminUsers()
    {
        return $this->belongsToMany(User::class, UserChaletAdmin::class, 'chalets_id', 'users_id');
    }
    // END Relationship:[7] => [Chalet Table] && [UserChaletAdmin Table]

    // START Relationship:[8] => [Chalet Table] && [ChaletImage Table]
    public function chaletReservations()
    {
        return $this->hasMany(ChaletReservation::class, 'chalets_id', 'id');
    }
    // END Relationship:[8] => [Chalet Table] && [ChaletImage Table]
}
