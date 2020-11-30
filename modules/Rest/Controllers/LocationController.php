<?php
namespace Modules\Rest\Controllers;
use App\Http\Controllers\Controller;
use http\Env\Request;
use Modules\Location\Models\Location;

class LocationController extends Controller
{
    public function list(){
        $rows = Location::where(['status' => 'publish'])->get();
        return response()->json($rows);
    }

    public function search(){
        $rows = Location::search(request());
        $total = $rows->total();
        return $this->sendSuccess(
            [
                'total'=>$total,
                'total_pages'=>$rows->lastPage(),
                'data'=>$rows->map(function($row){
                    return $row->dataForApi();
                }),
            ]
        );
    }

    public function detail($id = '')    {
        if(empty($id)){
            return $this->sendError(__("Location ID is not available"));
        }
        $row = Location::find($id);
        if(empty($row))
        {
            $this->sendError(__("Location not found"));
        }

        return $this->sendSuccess([
            'data'=>$row->dataForApi(true)
        ]);

    }

    public function gpx($filePath){
        try{
            $data = file_get_contents(public_path("uploads/tour_gpx_files/{$filePath}"));
            return response($data, 200, [
                'Content-Type' => 'application/xml'
            ]);
        }catch(\Exception $e){
            $this->sendError(__("Error reading gpx data"));
        }
    }
}
