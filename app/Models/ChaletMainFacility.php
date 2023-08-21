<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletMainFacility extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletMainFacility Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[1] => [ChaletMainFacility Table] && [Chalet Table]

    // START Relationship:[2] => [ChaletMainFacility Table] && [ChaletMainFacilitySubFacility Table]
    public function chaletMainFacilitySubFacilities()
    {
        return $this->hasMany(ChaletMainFacilitySubFacility::class, 'chalet_main_facility_id', 'id');
    }
    // END Relationship:[2] => [ChaletMainFacility Table] && [ChaletMainFacilitySubFacility Table]
}
