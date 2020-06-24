<?php
namespace Modules\Hike\Models;

use App\BaseModel;

class HikeCategoryTranslation extends BaseModel
{
    protected $table = 'bravo_hike_category_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $cleanFields = [
        'content'
    ];
}