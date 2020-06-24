<?php
namespace Modules\Hike\Models;

use App\BaseModel;

class HikeDate extends BaseModel
{
    protected $table = 'bravo_hike_dates';
    protected $hikeMetaClass;

    protected $casts = [
        'person_types'=>'array'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->hikeMetaClass = HikeMeta::class;
    }

    public static function getDatesInRanges($date,$target_id){
        return static::query()->where([
            ['start_date','>=',$date],
            ['end_date','<=',$date],
            ['target_id','=',$target_id],
        ])->first();
    }
    public function saveMeta(\Illuminate\Http\Request $request)
    {
        $locale = $request->input('lang');
        //TODO Bug found: there is not tour_date_id column in bravo_hike_meta table, Needs to be resolve
        // According to structural defination, used as foreign key as hike_id
        $meta = $this->hikeMetaClass::where('hike_id', $this->id)->first();
        if (!$meta) {
            $meta = new $this->hikeMetaClass();
            $meta->hike_id = $this->id;
        }
        return $meta->saveMetaOriginOrTranslation($request->input() , $locale);
    }
}
