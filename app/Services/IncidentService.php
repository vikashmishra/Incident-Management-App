<?php

namespace App\Services;

use App\Models\Incident;
use Illuminate\Support\Facades\Validator;

class IncidentService
{
    /**
     * Get all the incidents
     * @return array
     */
    public function get()
    {
        return Incident::get()->toArray();
    }
    
    /**
     * Validate incident API requests
     * @param type $request
     * @return type
     */
    public function validateIncident($request)
    {
        return Validator::make($request->all(), [
                'data.*.title'                  => 'required|unique:incidents|max:164',
                'data.*.people'                 => 'required',
                'data.*.location.latitude'      => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'data.*.location.longitude'     => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'data.*.category'               => ['required', 'numeric', 'exists:categories,id'],
                'data.*.incidentDate'           => ['required', 'date'],
                'data.*.createDate'             => ['required', 'date'],
                'data.*.modifyDate'             => ['required', 'date'],
                'data.*.comments'               => 'required',
            ]);
    }
}
