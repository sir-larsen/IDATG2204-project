<?php

use function PHPUnit\Framework\throwException;

require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';

/**
 * Class CustomerEndpoint for customer requests
 */
class CompanyEndpoint extends ResourceController
{
    /**
     * @var string is a string holding the user type for the current user of the endpoint
     */
    public $employeeType;

    /**
     * @var array containing implemented requests
     */
    private $validSubRequests;

    public function __construct(string $employeeType)
    {   
        parent::__construct();
        $this->employeeType = $employeeType; //Storing the employee type for later user checks
        //print($this->employeeType);

        //SETTING ALL ALLOWED METHODS AND REQUESTS HERE
        $this->validRequests[DBConstants::EMPLOYEE_CREP]     = RESTConstants::ENDPOINT_CREP;
        $this->validRequests[DBConstants::EMPLOYEE_SKEEPER]  = RESTConstants::ENDPOINT_SKEEPER;
        $this->validRequests[DBConstants::EMPLOYEE_PPLANNER] = RESTConstants::ENDPOINT_PPLANNER;

        //Setting the implemented sub requests
        $this->validSubRequests[RESTConstants::ENDPOINT_CREP] = array();
        $this->validSubRequests[RESTConstants::ENDPOINT_CREP][] = 'orders';

        //print_r($this->validRequests);
        //TBD REMEMBER TO DECLARE VALID METHODS HERE!!S
        
    }

    public function handleRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        //Checking if user is trying to access only the company part
        if (count($uri) == 0)
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);       //Throwing exception if this is the case
        else if ($this->validRequests[$this->employeeType] != $uri[0]) {                  //Checking if the user has written something that is either not permitted, or doesn't exist
            foreach ($this->validRequests as $key => $items) {                            //Looping through to check if the user tried to access a restricted endpoint
                if ($uri[0] == $key && $uri[0] != $this->employeeType)                 
                    throw new APIException(RESTConstants::HTTP_FORBIDDEN, $endpointPath); //If user tried to access something restricted, throw forbidden error
            }
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);       //Else throw a bad request error
        }
        print("cock\n");

        switch ($uri[0]) {
            case RESTConstants::ENDPOINT_CREP:
                $this->customerRepHandlder(array_slice($uri, 1), $endpointPath, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::ENDPOINT_SKEEPER:

                break;
            case RESTConstants::ENDPOINT_PPLANNER:

                break;
        }

        /*//Collection request
        if (count($uri) == 0) { 
            //Check if method is valid
                //If not valid throw error
                
            //handle the collection request-- Which means actually getting it DOCOLLECTIONREQUEST
            return $this->handleCollectionRequest($endpointPath, $requestMethod, $queries, $payload);
        }
        else if (count($uri) == 1) { //At this point, either an ID or further endpoint specifications has been sent
            if (!ctype_digit($uri[0])) { //This checks if there is an ID provided, or further sub requests in endpoint
                //Inside is if it is a sub request HANDLE SUBREQUEST IN HERE!!!
                //ERROR thrown in Rune example because it doesn't support sub-resources. e.g: localhost/customer/CHANGE_ORDER
            }
            //Check again if method is valid here
                //If not, throw error
            //Handle the resource request DORESOURCEREQUEST
        }*/
        
        //print_r($uri);
        
        return $this->handleCollectionRequest($endpointPath, $requestMethod, $queries, $payload);
        $res = array();
        return $res; //THIS IS JUST TO STOP INTELLISENSE RAGE; NOT A REAL RETURN*/
    }

    protected function customerRepHandlder(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        if (count($uri) == 0)                                                           //If no further arguments applied, throw bad request error
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);
        else {
            $exists = false;
            foreach ($this->validSubRequests[RESTConstants::ENDPOINT_CREP] as $item) {
                //print($item . "BIG COK\n");
                if ($item == $uri[0])
                    $exists = true;
            }
            if (!$exists)
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);
        }

        if (count($uri) == 1)

        //print("cock inside customer rep");
        //print_r($uri);
        
        $res = array();
        return $res; //THIS IS JUST TO STOP INTELLISENSE RAGE; NOT A REAL RETURN*/
    }
    
    protected function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        print("\n\n");
        $res = array();
        $res['hoi'] = 5;
        $res['Prompkus'] = 10;
        $res['status'] = RESTConstants::HTTP_OK;
        $res['result'] = array();
        $res['result'][] = 5;
        $res['result'][] = 'Prompkus';
        $res['result'][] = 7;
        $res['result'][] = 8;

        
        return $res;
    }

    protected function handleSubRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $res = array();
        return $res;
    }
}