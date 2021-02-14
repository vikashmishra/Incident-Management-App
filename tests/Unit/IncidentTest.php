<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Incident;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class IncidentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->getConnection()->beginTransaction();
    }
    
    /**
     * Test case to validate incident add functionality
     *
     * @return void
     */
    public function test_add_incident()
    {
        $testData = $this->getTestData();
        foreach ($testData as $tdata)
        {
            //Test all the columns are not null
            $this->assertNotEmpty($tdata['title']);
            $this->assertNotEmpty($tdata['location']);
            $this->assertNotEmpty($tdata['category']);
            $this->assertNotEmpty($tdata['people']);
            $this->assertNotEmpty($tdata['comments']);
            $this->assertNotEmpty($tdata['incident_time']);
            $this->assertNotEmpty($tdata['create_time']);
            $this->assertNotEmpty($tdata['update_time']);
            //Test valid latitude and longitude
            $decodedLatLong = json_decode($tdata['location']);
            $this->assertMatchesRegularExpression('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',$decodedLatLong->latitude);
            $this->assertMatchesRegularExpression('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',$decodedLatLong->longitude);
            //Test valid dates
            $this->assertTrue($this->validateDateFormat($tdata['incident_time']));
            $this->assertTrue($this->validateDateFormat($tdata['create_time']));
            $this->assertTrue($this->validateDateFormat($tdata['update_time']));
            //Test if category id is valid
            $isValidcategory = $this->checkValidCategory($tdata['category']);
            $this->assertTrue( $isValidcategory );
            //Test incident title should be unique
            $isTitleUnique = $this->checkTitleIsUnique($tdata['title']);
            $this->assertTrue( $isTitleUnique );
            //Save test data to database
            $this->saveIncident($tdata);
        }
        $this->getConnection()->rollback();
    }
    
    public function saveIncident($incident)
    {
        $currentDateTime        = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->toAtomString();
        $model                  = new Incident();
        $model->title           = $incident['title'];
        $model->location        = json_encode($incident['location']);
        $model->category        = $incident['category'];
        $model->people          = json_encode($incident['people']);
        $model->comments        = $incident['comments'];
        $model->incident_time   = $incident['incident_time'];
        $model->create_time     = $incident['create_time'] ? $incident['create_time'] : $currentDateTime;
        $model->update_time     = $incident['update_time'] ? $incident['update_time'] : $currentDateTime;
        $model->save();
    }
    
    /**
     * Get test data to validate test case
     * @return array
     */
    public function getTestData()
    {
        $people = [
            [
                'name' => 'Joy',
                'type' => 'staff'
            ],
            [
                'name' => 'Kevin',
                'type' => 'witness'
            ]
        ];
        $location           = ['latitude' => '12.9231501', 'longitude' => '74.7818517'];
        $currentDateTime    = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->toAtomString();
        return [
            [
                'title'         => 'Test Incident',
                'location'      => json_encode($location),
                'category'      => 2,
                'people'        => json_encode($people),
                'comments'      => 'Test Comment',
                'incident_time' => $currentDateTime,
                'create_time'   => $currentDateTime,
                'update_time'   => $currentDateTime
            ],
            [
                'title'         => 'Test Incident 2',
                'location'      => json_encode($location),
                'category'      => 3,
                'people'        => 'Test People',
                'comments'      => 'Test Comment',
                'incident_time' => $currentDateTime,
                'create_time'   => $currentDateTime,
                'update_time'   => $currentDateTime
            ]
        ];
    }
    
    /**
     * Check if category id is exist in the table
     * @param int $catId
     * @return boolean
     */
    public function checkValidCategory($catId)
    {
        $category = Category::where('id', $catId)->get()->count();
        if($category > 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Check if title is unique
     * @param string $title
     * @return boolean
     */
    public function checkTitleIsUnique($title)
    {
        $incident = Incident::where('title', $title)->get()->count();
        if($incident == 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Validate date format
     * @param type $attribute
     * @return boolean
     */
    public function validateDateFormat($attribute)
    {   
        $validator = Validator::make([$attribute], ['date']);
        if($validator->fails())
        {
            return false;
        }
        return true;
    }
}
