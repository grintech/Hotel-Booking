<?php

namespace Modules\Guesthouse\Models;

use App\BaseModel;

class GuesthouseTranslation extends Guesthouse
{
    protected $table = 'bravo_guesthouse_translations';

    protected $fillable = [
        'title',
        'content',
        'address',
        'policy'
    ];

    protected $slugField     = false;
    protected $seo_type = 'guesthouse_translation';

    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'policy'  => 'array',
    ];

    public function getSeoType(){
        return $this->seo_type;
    }
}