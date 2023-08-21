<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletImage extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletImage Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[1] => [ChaletImage Table] && [Chalet Table]
}
