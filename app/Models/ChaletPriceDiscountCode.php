<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletPriceDiscountCode extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletPriceDiscountCode Table] && [ChaletPrice Table]
    public function chaletPrice()
    {
        return $this->belongsTo(ChaletPrice::class, 'chalet_prices_id', 'id');
    }
    // END Relationship:[1] => [ChaletPriceDiscountCode Table] && [ChaletPrice Table]

    // START Relationship:[2] => [ChaletPriceDiscountCode Table] && [ChaletPrice Table]
    public function chaletReservation()
    {
        return $this->hasOne(ChaletReservation::class, 'chalet_price_discount_codes_id', 'id');
    }
    // END Relationship:[2] => [ChaletPriceDiscountCode Table] && [ChaletPrice Table]
}
