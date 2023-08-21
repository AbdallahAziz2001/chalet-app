<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChaletTerm extends Model
{
    use HasFactory;

    // START Relationship:[1] => [ChaletTerm Table] && [Chalet Table]
    public function chalet()
    {
        return $this->belongsTo(Chalet::class, 'chalets_id', 'id');
    }
    // END Relationship:[1] => [ChaletTerm Table] && [Chalet Table]
}
