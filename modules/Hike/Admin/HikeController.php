<?php
namespace Modules\Hike\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\AdminController;
use Modules\Core\Models\Attributes;
use Modules\Hike\Models\HikeCategory;
use Modules\Hike\Models\HikeTerm;
use Modules\Hike\Models\Hike;
use Modules\Hike\Models\HikeTranslation;
use Modules\Location\Models\Location;

class HikeController extends AdminController
{
    protected $hikeClass;
    protected $hikeTranslationClass;
    protected $hikeCategoryClass;
    protected $hikeTermClass;
    protected $attributesClass;
    protected $locationClass;

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/hike');
        $this->hikeClass = Hike::class;
        $this->hikeTranslationClass = HikeTranslation::class;
        $this->hikeCategoryClass = HikeCategory::class;
        $this->hikeTermClass = HikeTerm::class;
        $this->attributesClass = Attributes::class;
        $this->locationClass = Location::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('hike_view');
        $query = $this->hikeClass::query() ;
        $query->orderBy('id', 'desc');
        if (!empty($hike_name = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $hike_name . '%');
            $query->orderBy('title', 'asc');
        }
        if (!empty($cate = $request->input('cate_id'))) {
            $query->where('category_id', $cate);
        }
        if ($this->hasPermission('hike_manage_others')) {
            if (!empty($author = $request->input('vendor_id'))) {
                $query->where('create_user', $author);
            }
        } else {
            $query->where('create_user', Auth::id());
        }
        $data = [
            'rows'               => $query->with(['getAuthor','category_hike'])->paginate(20),
            'hike_categories'    => $this->hikeCategoryClass::where('status', 'publish')->get()->toTree(),
            'hike_manage_others' => $this->hasPermission('hike_manage_others'),
            'page_title'=>__("Hike Management"),
            'breadcrumbs'        => [
                [
                    'name' => __('Hikes'),
                    'url'  => 'admin/module/hike'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Hike::admin.index', $data);
    }

    public function create(Request $request)
    {
        $this->checkPermission('hike_create');
        $row = new Hike();
        $row->fill([
            'status' => 'publish'
        ]);
        $data = [
            'row'           => $row,
            'attributes'    => $this->attributesClass::where('service', 'hike')->get(),
            'hike_category' => $this->hikeCategoryClass::where('status', 'publish')->get()->toTree(),
            'hike_location' => $this->locationClass::where('status', 'publish')->get()->toTree(),
            'translation' => new $this->hikeTranslationClass(),
            'breadcrumbs'   => [
                [
                    'name' => __('Hikes'),
                    'url'  => 'admin/module/hike'
                ],
                [
                    'name'  => __('Add Hike'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Hike::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('hike_update');
        $row = $this->hikeClass::find($id);
        if (empty($row)) {
            return redirect('admin/module/hike');
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        if (!$this->hasPermission('hike_manage_others')) {
            if ($row->create_user != Auth::id()) {
                return redirect('admin/module/hike');
            }
        }
        $data = [
            'row'            => $row,
            'translation'    => $translation,
            "selected_terms" => $row->hike_term->pluck('term_id'),
            'attributes'     => $this->attributesClass::where('service', 'hike')->get(),
            'hike_category'  => $this->hikeCategoryClass::where('status', 'publish')->get()->toTree(),
            'hike_location'  => $this->locationClass::where('status', 'publish')->get()->toTree(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Hikes'),
                    'url'  => 'admin/module/hike'
                ],
                [
                    'name'  => __('Edit Hike'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Hike::admin.detail', $data);
    }

    public function store( Request $request, $id ){

        if($id > 0){
            $this->checkPermission('hike_update');
            $row = $this->hikeClass::find($id);
            if (empty($row)) {
                return redirect(route('hike.admin.index'));
            }
            if($row->create_user != Auth::id() and !$this->hasPermission('hike_manage_others'))
            {
                return redirect(route('space.admin.index'));
            }

        }else{
            $this->checkPermission('hike_create');
            $row = new $this->hikeClass();
            $row->status = "publish";
        }
        $row->fill($request->input());
	    $row->ical_import_url  = $request->ical_import_url;
	    $row->create_user = $request->input('create_user');
        $row->default_state = $request->input('default_state',1);

        if ($request->hasFile('gpx_file')) {
            $validator = Validator::make(
                [
                    'gpx_file'      => $request->gpx_file,
                    'extension' => strtolower($request->gpx_file->getClientOriginalExtension()),
                ],
                [
                    'gpx_file'          => 'required',
                    'extension'      => 'required|in:gpx',
                ]
            );
            if($validator->fails()){
                return back()->with('success',  __('Only GPX Files are Allowed.') );
            }
            $file = $request->file('gpx_file');
            $name = time().'.'.$file->getClientOriginalName();
            $destinationPath = public_path('/uploads/tour_gpx_files');
            $file->move($destinationPath, $name);
            $row->gpx_file = '/uploads/tour_gpx_files/'.$name;
        }
        $res = $row->saveOriginOrTranslation($request->input('lang'),true);
        if ($res) {
            if(!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
                $row->saveMeta($request);
            }
            if($id > 0 ){
                return back()->with('success',  __('Hike updated') );
            }else{
                return redirect(route('hike.admin.edit',$row->id))->with('success', __('Hike created') );
            }
        }
    }

    public function saveTerms($row, $request)
    {
        if (empty($request->input('terms'))) {
            $this->hikeTermClass::where('hike_id', $row->id)->delete();
        } else {
            $term_ids = $request->input('terms');
            foreach ($term_ids as $term_id) {
                $this->hikeTermClass::firstOrCreate([
                    'term_id' => $term_id,
                    'hike_id' => $row->id
                ]);
            }
            $this->hikeTermClass::where('hike_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
        }
    }

    public function bulkEdit(Request $request)
    {

        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }

        switch ($action){
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->hikeClass::where("id", $id);
                    if (!$this->hasPermission('hike_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('hike_delete');
                    }
                    $query->first();
                    if(!empty($query)){
                        $query->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            case "clone":
                $this->checkPermission('hike_create');
                foreach ($ids as $id) {
                    (new $this->hikeClass())->saveCloneByID($id);
                }
                return redirect()->back()->with('success', __('Clone success!'));
                break;
            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->hikeClass::where("id", $id);
                    if (!$this->hasPermission('hike_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('hike_update');
                    }
                    $query->update(['status' => $action]);
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }
    }
}
