<?php
namespace Modules\Core\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\AdminController;
use Modules\Core\Models\Menu;
use Modules\Core\Models\MenuTranslation;
use Modules\News\Models\NewsCategory;
use Modules\Page\Models\Template;

class CommandController extends AdminController {
    protected $allowed = [
        'config:clear',
        'view:clear',
        'route:clear',
        'cache:clear',
        'clear-compiled',
        'cache:clear'
    ];

    public function call($command){
        if(array_search($command , $this->allowed)){
            try{
                Artisan::call($command);
                return response('Commander Success');
            }catch(\Exception $e){
                dd($e);
            }
        }
    }
}
