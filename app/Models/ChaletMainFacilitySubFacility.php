<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletMainFacilitySubFacility extends Model
{
    use HasFactory;

        // START Relationship:[1] => [ChaletMainFacilitySubFacility Table] && [ChaletMainFacility Table]
        public function chaletMainFacility()
        {
            return $this->belongsTo(ChaletMainFacility::class, 'chalet_main_facility_id', 'id');
        }
        // END Relationship:[1] => [ChaletMainFacilitySubFacility Table] && [ChaletMainFacility Table]
}
