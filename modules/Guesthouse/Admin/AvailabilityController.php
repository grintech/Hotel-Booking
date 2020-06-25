<?php
namespace Modules\Guesthouse\Admin;

use Illuminate\Support\Facades\Auth;

class AvailabilityController extends \Modules\Guesthouse\Controllers\AvailabilityController
{
    protected $indexView = 'Guesthouse::admin.room.availability';

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/guesthouse');
        $this->middleware('dashboard');
    }

    protected function hasGuesthousePermission($guesthouse_id = false){
        if(empty($guesthouse_id)) return false;

        $guesthouse = $this->guesthouseClass::find($guesthouse_id);
        if(empty($guesthouse)) return false;

        if(!$this->hasPermission('guesthouse_manage_others') and $guesthouse->create_user != Auth::id()){
            return false;
        }

        $this->currentGuesthouse = $guesthouse;
        return true;
    }
}