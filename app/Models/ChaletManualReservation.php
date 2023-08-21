<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletManualReservation extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletManualReservation Table] && [ChaletReservation Table]
    public function chaletReservation()
    {
        return $this->morphOne(ChaletReservation::class, 'object', 'object_type', 'object_id', 'id');
    }
    // END Relationship:[1] => [ChaletManualReservation Table] && [ChaletReservation Table]
}
