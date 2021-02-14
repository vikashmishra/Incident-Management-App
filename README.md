# Incident-management-App
Clone or download repositery and place it to web accessable folder.

Nevigate to .env file and configure database also create a databse with the name which you wil write down inside .env file.

Run migration usin "php artisan migrate" command from your command line to execute all the necessary migrations.

Run "php artisan db:seed --class=CategorySeeder" command from your command prompt to insert required data in database.

Use below POST endpoint to add incident
http://projectroot/api/add (example - https://incidentmanagement/api/add)

# Below is the sample code of POST endpoint of my local machine

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/incident-management/api/add',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "data": [
        {
            "id": 0,
            "location": {
                "latitude": 12.9231501,
                "longitude": 74.7818517
            },
            "title": "Test Incident",
            "category": 3,
            "people": [
                {
                    "name": "Joy",
                    "type": "staff"
                },
                {
                    "name": "Kevin",
                    "type": "witness"
                },
                {
                    "name": "Danni",
                    "type": "staff"
                }
            ],
            "comments": "This is a string of comments",
            "incidentDate": "2020-09-01T13:26:00+00:00",
            "createDate": "2020-09-01T13:32:59+02:00",
            "modifyDate": "2020-09-01T13:32:59+01:00"
        }
    ]
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

Use below GET endpoint to get list of added incidents
http://projectroot/api/get (example - https://incidentmanagement/api/get)

Test cases for the API has been written inside "tests/Unit/IncidentTest.php". Use "phpunit" command to execute test cases or if you want to execute any spefic test case class then use "phpunit Tests\Unit\UnitTestClass.php" command from command prompt. 


