<?php
namespace Modules\Hike\Controllers;

use Illuminate\Support\Facades\Validator;
use Modules\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Hike\Models\Hike;
use Modules\Hike\Models\HikeCategory;
use Modules\Hike\Models\HikeTerm;
use Modules\Hike\Models\HikeTranslation;
use Modules\Location\Models\Location;
use Modules\Core\Models\Attributes;
use Modules\Booking\Models\Booking;

class ManageHikeController extends FrontendController
{
    protected $hikeClass;
    protected $hikeTranslationClass;
    protected $hikeCategoryClass;
    protected $hikeTermClass;
    protected $attributesClass;
    protected $locationClass;
    protected $bookingClass;

    public function __construct()
    {
        $this->hikeClass = Hike::class;
        $this->hikeTranslationClass = HikeTranslation::class;
        $this->hikeCategoryClass = HikeCategory::class;
        $this->hikeTermClass = HikeTerm::class;
        $this->attributesClass = Attributes::class;
        $this->locationClass = Location::class;
        $this->bookingClass = Booking::class;
        parent::__construct();
    }

    public function callAction($method, $parameters)
    {
        if (setting_item('hike_disable')) {
            return redirect('/');
        }
        return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
    }

    public function manageHike(Request $request)
    {
        $this->checkPermission('hike_view');
        $user_id = Auth::id();
        $list_hike = $this->hikeClass::where("create_user", $user_id)->orderBy('id', 'desc');
        $data = [
            'rows'        => $list_hike->paginate(5),
            'breadcrumbs' => [
                [
                    'name' => __('Manage Hikes'),
                    'url'  => route('hike.vendor.index'),
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Manage Hikes"),
        ];
        return view('Hike::frontend.manageHike.index', $data);
    }

    public function createHike(Request $request)
    {
        $this->checkPermission('hike_create');
        $row = new $this->hikeClass();
        $data = [
            'row'           => $row,
            'translation'   => new $this->hikeTranslationClass(),
            'hike_category' => $this->hikeCategoryClass::get()->toTree(),
            'hike_location' => $this->locationClass::where("status", "publish")->get()->toTree(),
            'attributes'    => $this->attributesClass::where('service', 'hike')->get(),
            'breadcrumbs'   => [
                [
                    'name' => __('Manage Hikes'),
                    'url'  => route('hike.vendor.index'),
                ],
                [
                    'name'  => __('Create'),
                    'class' => 'active'
                ],
            ],
            'page_title'    => __("Create Hikes"),
        ];
        return view('Hike::frontend.manageHike.detail', $data);
    }

    public function editHike(Request $request, $id)
    {
        $this->checkPermission('hike_update');
        $user_id = Auth::id();
        $row = $this->hikeClass::where("create_user", $user_id);
        $row = $row->find($id);
        if (empty($row)) {
            return redirect(route('hike.vendor.index'))->with('warning', __('Hike not found!'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        $data = [
            'translation'    => $translation,
            'row'            => $row,
            'hike_category'  => $this->hikeCategoryClass::where("status", "publish")->get()->toTree(),
            'hike_location'  => $this->locationClass::where("status", "publish")->get()->toTree(),
            'attributes'     => $this->attributesClass::where('service', 'hike')->get(),
            "selected_terms" => $row->hike_term->pluck('term_id'),
            'breadcrumbs'    => [
                [
                    'name' => __('Manage Hikes'),
                    'url'  => route('hike.vendor.index'),
                ],
                [
                    'name'  => __('Edit'),
                    'class' => 'active'
                ],
            ],
            'page_title'     => __("Edit Hikes"),
        ];
        return view('Hike::frontend.manageHike.detail', $data);
    }

    public function store(Request $request, $id)
    {
        if ($id > 0) {
            $this->checkPermission('hike_update');
            $row = $this->hikeClass::find($id);
            if (empty($row)) {
                return redirect(route('hike.vendor.edit', ['id' => $row->id]));
            }
            if ($row->create_user != Auth::id() and !$this->hasPermission('hike_manage_others')) {
                return redirect(route('hike.vendor.edit', ['id' => $row->id]));
            }
        } else {
            $this->checkPermission('hike_create');
            $row = new $this->hikeClass();
            $row->status = "publish";
            if (setting_item("hike_vendor_create_service_must_approved_by_admin", 0)) {
                $row->status = "pending";
            }
        }
        $row->fillByAttr([
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
            'image_id',
            'banner_image_id',
            'short_desc',
            'category_id',
            'location_id',
            'address',
            'map_lat',
            'map_lng',
            'map_zoom',
            'gallery',
            'video',
            'default_state',
            'price',
            'sale_price',
            'duration',
            'distance',
            'ascent',
            'descent',
            'techniques',
            'max_people',
            'min_people',
            'faqs',
            'include',
            'exclude',
            'itinerary',
        ], $request->input());

        if ($request->hasFile('gpx_file')) {
            $validator = Validator::make([
                    'gpx_file'      => $request->gpx_file,
                    'extension' => strtolower($request->gpx_file->getClientOriginalExtension()),
                ], [
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
            }
            $row->saveMeta($request);
            if($id > 0 ){
                return back()->with('success',  __('Hike updated') );
            }else{
                return redirect(route('hike.vendor.edit',['id'=>$row->id]))->with('success', __('Hike created') );
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

    public function deleteHike($id)
    {
        $this->checkPermission('hike_delete');
        $user_id = Auth::id();
        $query = $this->hikeClass::where("create_user", $user_id)->where("id", $id)->first();
        if (!empty($query)) {
            $query->delete();
        }
        return redirect(route('hike.vendor.index'))->with('success', __('Delete hike success!'));
    }

    public function bulkEditHike($id, Request $request)
    {
        $this->checkPermission('hike_update');
        $action = $request->input('action');
        $user_id = Auth::id();
        $query = $this->hikeClass::where("create_user", $user_id)->where("id", $id)->first();
        if (empty($id)) {
            return redirect()->back()->with('error', __('No item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if (empty($query)) {
            return redirect()->back()->with('error', __('Not Found'));
        }
        switch ($action) {
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

    public function bookingReport(Request $request)
    {
        $data = [
            'bookings'    => $this->bookingClass::getBookingHistory($request->input('status'), false, Auth::id(), 'hike'),
            'statues'     => config('booking.statuses'),
            'breadcrumbs' => [
                [
                    'name' => __('Manage Hikes'),
                    'url'  => route('hike.vendor.index'),
                ],
                [
                    'name'  => __('Booking Report'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Booking Report"),
        ];
        return view('Hike::frontend.manageHike.bookingReport', $data);
    }

    public function bookingReportBulkEdit($booking_id, Request $request)
    {
        $status = $request->input('status');
        if (!empty(setting_item("hike_allow_vendor_can_change_their_booking_status")) and !empty($status) and !empty($booking_id)) {
            $query = $this->bookingClass::where("id", $booking_id);
            $query->where("vendor_id", Auth::id());
            $item = $query->first();
            if (!empty($item)) {
                $item->status = $status;
                $item->save();
                $item->sendStatusUpdatedEmails();
                return redirect()->back()->with('success', __('Update success'));
            }
            return redirect()->back()->with('error', __('Booking not found!'));
        }
        return redirect()->back()->with('error', __('Update fail!'));
    }

    public function cloneHike(Request $request, $id)
    {
        $this->checkPermission('hike_update');
        $user_id = Auth::id();
        $row = $this->hikeClass::where("create_user", $user_id);
        $row = $row->find($id);
        if (empty($row)) {
            return redirect(route('hike.vendor.index'))->with('warning', __('Hike not found!'));
        };
        try {
            $clone = $row->replicate();
            $clone->status = 'draft';
            $clone->push();
            if (!empty($row->hike_term)) {
                foreach ($row->hike_term as $term) {
                    $e = $term->replicate();
                    if ($e->push()) {
                        $clone->hike_term()->save($e);
                    }
                }
            }
            if (!empty($row->meta)) {
                $e = $row->meta->replicate();
                if ($e->push()) {
                    $clone->meta()->save($e);
                }
            }
            if (!empty($row->translations)) {
                foreach ($row->translations as $translation) {
                    $e = $translation->replicate();
                    $e->origin_id = $clone->id;
                    if ($e->push()) {
                        $clone->translations()->save($e);
                    }
                }
            }
            return redirect()->back()->with('success', __('Hike clone was successful'));
        } catch (\Exception $exception) {
            $clone->delete();
            return redirect()->back()->with('warning', __($exception->getMessage()));
        }
    }
}
