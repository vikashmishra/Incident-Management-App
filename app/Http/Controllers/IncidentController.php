<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\IncidentService;


class IncidentController extends Controller
{
    protected $incidentService;

    public function __construct(IncidentService $incidentService)
    {
        $this->incidentService = $incidentService;
    }
    
    /**
     * Validate and add incidents.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $validator = $this->incidentService->validateIncident($request);
        if($validator->fails()) 
        {
            return response()->json(['success' => false , 'data' => $validator->errors()]);
        }
        $currentDateTime    = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->toAtomString();
        foreach($request->all()['data'] as $reqData)
        {
                $model                  = new Incident();
                $model->title           = $reqData['title'];
                $model->location        = json_encode($reqData['location']);
                $model->category        = $reqData['category'];
                $model->people          = json_encode($reqData['people']);
                $model->comments        = $reqData['comments'];
                $model->incident_time   = $reqData['incidentDate'];
                $model->create_time     = $reqData['createDate'] ? $reqData['createDate'] : $currentDateTime;
                $model->update_time     = $reqData['modifyDate'] ? $reqData['modifyDate'] : $currentDateTime;
                $model->save();
        }
        return response()->json(['success' => true, 'msg' => 'Incidents added successfully']);
    }
    
    /**
     * Get incident list
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $data = $this->incidentService->get();
        return response()->json(['data' => $data], 200, [], JSON_PRETTY_PRINT);
    }
}
