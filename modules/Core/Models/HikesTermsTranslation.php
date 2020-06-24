<?php

namespace Modules\Core\Models;



use App\BaseModel;



class HikesTermsTranslation extends BaseModel

{

    protected $table = 'hikes_terms_translations';

    protected $fillable = [

        'name',

        'content',

    ];

    protected $cleanFields = [

        'content'

    ];

}