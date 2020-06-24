<?php

namespace Modules\Core\Models;



use App\BaseModel;



class HikesAttributesTranslation extends BaseModel

{

    protected $table = 'hikes_attrs_translations';

    protected $fillable = [

        'name',

    ];

}