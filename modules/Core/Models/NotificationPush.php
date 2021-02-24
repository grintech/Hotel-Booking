<?php
namespace Modules\Core\Models;

use App\BaseModel;

class NotificationPush extends BaseModel
{
    protected $table  = 'notifications';

    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

}
