<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChaletPrice extends Model
{
    use HasFactory, SoftDeletes;

    // START Relationship:[1] => [ChaletPrice Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[1] => [ChaletPrice Table] && [Chalet Table]

    // START Relationship:[2] => [ChaletPrice Table] && [ChaletPriceDiscountCode Table]
    public function chaletPriceDiscountCodes()
    {
        return $this->hasMany(ChaletPriceDiscountCode::class, 'chalet_prices_id', 'id');
    }
    // END Relationship:[2] => [ChaletPrice Table] && [ChaletPriceDiscountCode Table]
}
