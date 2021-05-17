<?php
namespace Modules\Hike\Models;

use App\BaseModel;

class HikeTranslation extends BaseModel
{
    protected $table = 'bravo_hikes_translations';
    protected $fillable = [
        'title',
        'content',
        'the_tour',
        'Turn_by_turn_locations',
        'getting_there',
        'literature',
        'current_information',
        'highest_point',
        'lowest_point',
        'experience',
        'landscape',
        'best_time',
        'safety_information',
        'gpx_file',
        'short_desc',
        'address',
        'faqs',
        'include',
        'exclude',
        'itinerary',
    ];
    protected $slugField     = false;
    protected $seo_type = 'hike_translation';
    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'faqs' => 'array',
        'include' => 'array',
        'exclude' => 'array',
        'itinerary' => 'array',
        'surrounding' => 'array',
    ];
    public function getSeoType(){
        return $this->seo_type;
    }

    public function getRecordRoot(){
        return $this->belongsTo(Tour::class,'origin_id');
    }
}
