<?php
namespace Modules\Guesthouse\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Core\Models\Attributes;
use Modules\Guesthouse\Models\GuesthouseRoom;
use Modules\Guesthouse\Models\GuesthouseRoomTerm;
use Modules\Guesthouse\Models\GuesthouseRoomTranslation;
use Modules\Location\Models\Location;
use Modules\Guesthouse\Models\Guesthouse;
use Modules\Guesthouse\Models\GuesthouseTerm;
use Modules\Guesthouse\Models\GuesthouseTranslation;

class VendorRoomController extends FrontendController
{
    protected $guesthouseClass;
    protected $roomTermClass;
    protected $attributesClass;
    protected $locationClass;
    /**
     * @var GuesthouseRoom
     */
    protected $roomClass;
    protected $currentGuesthouse;
    protected $roomTranslationClass;

    public function __construct()
    {
        parent::__construct();
        $this->guesthouseClass = Guesthouse::class;
        $this->roomTermClass = GuesthouseRoomTerm::class;
        $this->attributesClass = Attributes::class;
        $this->locationClass = Location::class;
        $this->roomClass = GuesthouseRoom::class;
        $this->roomTranslationClass = GuesthouseRoomTranslation::class;
    }

    protected function hasGuesthousePermission($guesthouse_id = false){
        if(empty($guesthouse_id)) return false;
        $guesthouse = $this->guesthouseClass::find($guesthouse_id);
        if(empty($guesthouse)) return false;
        if(!$this->hasPermission('guesthouse_update') and $guesthouse->create_user != Auth::id()){
            return false;
        }
        $this->currentGuesthouse = $guesthouse;
        return true;
    }
    public function index(Request $request,$guesthouse_id)
    {
        $this->checkPermission('guesthouse_view');

        if(!$this->hasGuesthousePermission($guesthouse_id))
        {
            abort(403);
        }
        $query = $this->roomClass::query() ;
        $query->orderBy('id', 'desc');
        if (!empty($guesthouse_name = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $guesthouse_name . '%');
            $query->orderBy('title', 'asc');
        }
        $query->where('parent_id',$guesthouse_id);
        $data = [
            'rows'               => $query->with(['author'])->paginate(20),
            'breadcrumbs'        => [
                [
                    'name' => __('Guesthouses'),
                    'url'  => route('guesthouse.vendor.index')
                ],
                [
                    'name' => __('Guesthouse: :name',['name'=>$this->currentGuesthouse->title]),
                    'url'  => route('guesthouse.vendor.edit',[$this->currentGuesthouse->id])
                ],
                [
                    'name'  => __('All Rooms'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Room Management"),
            'guesthouse'=>$this->currentGuesthouse,
            'row'=> new $this->roomClass(),
            'translation'=>new $this->roomTranslationClass(),
            'attributes'     => $this->attributesClass::where('service', 'guesthouse_room')->get(),
        ];
        return view('Guesthouse::frontend.vendorGuesthouse.room.index', $data);
    }

    public function create($guesthouse_id)
    {
        $this->checkPermission('guesthouse_update');

        if(!$this->hasGuesthousePermission($guesthouse_id))
        {
            abort(403);
        }
        $row = new $this->roomClass();
        $translation = new $this->roomTranslationClass();
        $data = [
            'row'            => $row,
            'translation'    => $translation,
            'attributes'     => $this->attributesClass::where('service', 'guesthouse_room')->get(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Guesthouses'),
                    'url'  => route('guesthouse.vendor.index')
                ],
                [
                    'name' => __('Guesthouse: :name',['name'=>$this->currentGuesthouse->title]),
                    'url'  => route('guesthouse.vendor.edit',[$this->currentGuesthouse->id])
                ],
                [
                    'name' => __('All Rooms'),
                    'url'  => route("guesthouse.vendor.room.index",['guesthouse_id'=>$this->currentGuesthouse->id])
                ],
                [
                    'name'  => __('Create'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Create Room"),
            'guesthouse'=>$this->currentGuesthouse
        ];
        return view('Guesthouse::frontend.vendorGuesthouse.room.detail', $data);
    }

    public function edit(Request $request, $guesthouse_id,$id)
    {
        $this->checkPermission('guesthouse_update');

        if(!$this->hasGuesthousePermission($guesthouse_id))
        {
            abort(403);
        }

        $row = $this->roomClass::find($id);
        if (empty($row) or $row->parent_id != $guesthouse_id) {
            return redirect(route('guesthouse.vendor.room.index',['guesthouse_id'=>$guesthouse_id]));
        }

        $translation = $row->translateOrOrigin($request->query('lang'));

        $data = [
            'row'            => $row,
            'translation'    => $translation,
            "selected_terms" => $row->terms->pluck('term_id'),
            'attributes'     => $this->attributesClass::where('service', 'guesthouse_room')->get(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Guesthouses'),
                    'url'  => route('guesthouse.vendor.index')
                ],
                [
                    'name' => __('Guesthouse: :name',['name'=>$this->currentGuesthouse->title]),
                    'url'  => route('guesthouse.vendor.edit',[$this->currentGuesthouse->id])
                ],
                [
                    'name' => __('All Rooms'),
                    'url'  => route("guesthouse.vendor.room.index",['guesthouse_id'=>$this->currentGuesthouse->id])
                ],
                [
                    'name' => __('Edit room: :name',['name'=>$row->title]),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Edit: :name",['name'=>$row->title]),
            'guesthouse'=>$this->currentGuesthouse
        ];
        return view('Guesthouse::frontend.vendorGuesthouse.room.detail', $data);
    }

    public function store( Request $request, $guesthouse_id,$id ){

        if(!$this->hasGuesthousePermission($guesthouse_id))
        {
            abort(403);
        }
        if($id>0){
            $this->checkPermission('guesthouse_update');
            $row = $this->roomClass::find($id);
            if (empty($row)) {
                return redirect(route('guesthouse.vendor.index'));
            }
            if($row->parent_id != $guesthouse_id)
            {
                return redirect(route('guesthouse.vendor.room.index'));
            }
        }else{
            $this->checkPermission('guesthouse_create');
            $row = new $this->roomClass();
            $row->status = "publish";
        }

        $dataKeys = [
            'title',
            'content',
            'image_id',
            'gallery',
            'price',
            'number',
            'beds',
            'size',
            'adults',
            'children',
        ];

        $row->fillByAttr($dataKeys,$request->input());

        if(!empty($id) and $id == "-1"){
            $row->parent_id = $guesthouse_id;
        }

        $res = $row->saveOriginOrTranslation($request->input('lang'),true);

        if ($res) {
            if(!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }

            if($id > 0 ){
                return redirect()->back()->with('success',  __('Room updated') );
            }else{
                return redirect(route('guesthouse.vendor.room.edit',['guesthouse_id'=>$guesthouse_id,'id'=>$row->id]))->with('success', __('Room created') );
            }
        }
    }

    public function saveTerms($row, $request)
    {
        if (empty($request->input('terms'))) {
            $this->roomTermClass::where('target_id', $row->id)->delete();
        } else {
            $term_ids = $request->input('terms');
            foreach ($term_ids as $term_id) {
                $this->roomTermClass::firstOrCreate([
                    'term_id' => $term_id,
                    'target_id' => $row->id
                ]);
            }
            $this->roomTermClass::where('target_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
        }
    }

    public function delete($guesthouse_id,$id )
    {
        $this->checkPermission('guesthouse_delete');
        $user_id = Auth::id();
        $query = $this->roomClass::where("parent_id", $guesthouse_id)->where("id", $id)->first();
        if(!empty($query)){
            $query->delete();
        }
        return redirect()->back()->with('success', __('Delete room success!'));
    }

    public function bulkEdit(Request $request , $guesthouse_id , $id)
    {
        $this->checkPermission('guesthouse_update');
        $action = $request->input('action');
        $user_id = Auth::id();
        $query = $this->roomClass::where("parent_id", $guesthouse_id)->where("id", $id)->first();
        if (empty($id)) {
            return redirect()->back()->with('error', __('No item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if(empty($query)){
            return redirect()->back()->with('error', __('Not Found'));
        }
        switch ($action){
            case "make-hide":
                $query->status = "draft";
                break;
            case "make-publish":
                $query->status = "publish";
                break;
        }
        $query->save();
        return redirect()->back()->with('success', __('Update success!'));
    }
}