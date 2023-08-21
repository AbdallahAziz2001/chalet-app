<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletAutomaticReservation extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletAutomaticReservation Table] && [User Table]
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // END Relationship:[1] => [ChaletAutomaticReservation Table] && [User Table]

    // START Relationship:[2] => [ChaletAutomaticReservation Table] && [ChaletReservation Table]
    public function chaletReservation()
    {
        return $this->morphOne(ChaletReservation::class, 'object', 'object_type', 'object_id', 'id');
    }
    // END Relationship:[2] => [ChaletAutomaticReservation Table] && [ChaletReservation Table]

}
