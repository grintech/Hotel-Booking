<?php
namespace Modules\Guesthouse\Models;

use App\BaseModel;

class GuesthouseRoomTerm extends BaseModel
{
    protected $table = 'bravo_guesthouse_room_term';
    protected $fillable = [
        'term_id',
        'target_id'
    ];
}