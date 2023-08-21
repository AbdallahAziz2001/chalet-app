<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletReservation extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletReservation Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[1] => [ChaletReservation Table] && [Chalet Table]

    // START Relationship:[2] => [ChaletReservation Table] && ([ChaletAutomaticReservation Table] || [ChaletManualReservation Table])
    public function chaletReservationObject()
    {
        return $this->morphTo('object', 'object_type', 'object_id');
    }
    // END Relationship:[2] => [ChaletReservation Table] && ([ChaletAutomaticReservation Table] || [ChaletManualReservation Table])

    // START Relationship:[3] => [ChaletReservation Table] && [chaletPriceDiscountCode Table]
    public function chaletPriceDiscountCode()
    {
        return $this->belongsTo(Chalet::class, 'chalet_price_discount_codes_id', 'id');
    }
    // END Relationship:[3] => [ChaletReservation Table] && [chaletPriceDiscountCode Table]


}
