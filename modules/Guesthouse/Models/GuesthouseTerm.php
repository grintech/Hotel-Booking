<?php
namespace Modules\Guesthouse\Models;

use App\BaseModel;

class GuesthouseTerm extends BaseModel
{
    protected $table = 'bravo_guesthouse_term';
    protected $fillable = [
        'term_id',
        'target_id'
    ];
}