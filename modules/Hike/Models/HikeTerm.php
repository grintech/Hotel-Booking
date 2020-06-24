<?php
namespace Modules\Hike\Models;

use App\BaseModel;

class HikeTerm extends BaseModel
{
    protected $table = 'bravo_hike_term';
    protected $fillable = [
        'term_id',
        'hike_id'
    ];
}