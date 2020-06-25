<?php

namespace Modules\Guesthouse\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Booking\Models\Bookable;
use Modules\Booking\Models\Booking;
use Modules\Core\Models\SEO;
use Modules\Media\Helpers\FileHelper;
use Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Guesthouse\Models\GuesthouseTranslation;
use Modules\User\Models\UserWishList;

class GuesthouseRoomTranslation extends Bookable
{
    use SoftDeletes;
    protected $table = 'bravo_guesthouse_room_translations';
    public $type = 'guesthouse_room_translation';

    protected $fillable = [
        'title',
        'content',
        'status',
    ];

    protected $seo_type = 'guesthouse_room_translation';


    protected $bookingClass;
    protected $reviewClass;
    protected $guesthouseDateClass;
    protected $guesthouseRoomTermClass;
    protected $guesthouseTranslationClass;
    protected $userWishListClass;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->bookingClass = Booking::class;
        $this->reviewClass = Review::class;
        $this->guesthouseRoomTermClass = GuesthouseRoomTerm::class;
        $this->guesthouseTranslationClass = GuesthouseTranslation::class;
        $this->userWishListClass = UserWishList::class;
    }

    public static function getModelName()
    {
        return __("Guesthouse Room");
    }

    public static function getTableName()
    {
        return with(new static)->table;
    }


    public function terms(){
        return $this->hasMany($this->guesthouseRoomTermClass, "target_id");
    }
}
