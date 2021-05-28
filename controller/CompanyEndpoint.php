<?php

use function PHPUnit\Framework\throwException;

require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';
require_once 'db/CompanyModel.php';

//http://localhost/api/company/customer_rep/orders?state=new,open,skis-avaliable,ready-to-be-shipped
//http://localhost/api/company/customer_rep/orders?state=new,open,skis-avaliable
//http://localhost/api/company/customer_rep/orders

//POST request
//company/customer_rep/orders{:employee_nr}/{:order_number}/{:new_state}

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

        //SETTING ALL ALLOWED METHODS AND REQUESTS HERE
        $this->validRequests[DBConstants::EMPLOYEE_CREP]     = RESTConstants::ENDPOINT_CREP;
        $this->validRequests[DBConstants::EMPLOYEE_SKEEPER]  = RESTConstants::ENDPOINT_SKEEPER;
        $this->validRequests[DBConstants::EMPLOYEE_PPLANNER] = RESTConstants::ENDPOINT_PPLANNER;

        //Setting the implemented sub requests
        $this->validSubRequests[RESTConstants::ENDPOINT_CREP] = array();
        $this->validSubRequests[RESTConstants::ENDPOINT_CREP][] = RESTConstants::SUB_ENDPOINT_ORDERS;

        //Defining the allowed methods for endpoints
        $this->validMethods[RESTConstants::SUB_ENDPOINT_ORDERS] = array();
        $this->validMethods[RESTConstants::SUB_ENDPOINT_ORDERS][RESTConstants::METHOD_GET] = RESTConstants::HTTP_OK;
        $this->validMethods[RESTConstants::SUB_ENDPOINT_ORDERS][RESTConstants::METHOD_POST] = RESTConstants::HTTP_OK;
    }

    /**
     * The main function handling the client request to this api endpoint.
     * @param array $uri the part of the requested URI that is still to be processed after being exploded to an array.
     * @param string $endpointPath the path to the current resource.
     * @param string $requestMethod the method being requested.
     * @param array $queries the query string from the client
     * @param array $payload the JSON payload received from the client - after being decoded to an array structure
     * @return array an associative array where the status is
     *         one of the HTTP status codes indicating the success of the operation and result being the resource
     *         representation to be returned to the client.
     * @throws APIException in the case of resources not found, bad requests, methods not implemented, etc.
     */
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

        switch ($uri[0]) {
            case RESTConstants::ENDPOINT_CREP:
                return $this->customerRepHandlder(array_slice($uri, 1), $endpointPath, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::ENDPOINT_SKEEPER:
                //Funksjonskall
                break;
            case RESTConstants::ENDPOINT_PPLANNER:
                //Funksjonskall
                break;
        }
    }

    /**
     * Secondaryb function handling calls to the customer_rep endpoint.
     * @param array $uri the part of the requested URI that is still to be processed after being exploded to an array.
     * @param string $endpointPath the path to the current resource.
     * @param string $requestMethod the method being requested.
     * @param array $queries the query string from the client
     * @param array $payload the JSON payload received from the client - after being decoded to an array structure
     * @return array an associative array where the status is
     *         one of the HTTP status codes indicating the success of the operation and result being the resource
     *         representation to be returned to the client.
     * @throws APIException in the case of resources not found, bad requests, methods not implemented, etc.
     */    
    protected function customerRepHandlder(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        if (count($uri) == 0)                                                           //If no further arguments applied, throw bad request error
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);
        else {
            $exists = false;
            foreach ($this->validSubRequests[RESTConstants::ENDPOINT_CREP] as $item) {
                if ($item == $uri[0])
                    $exists = true;
            }
            if (!$exists)
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);
        }

        if (count($uri) == 1) {
            if (($outcome = $this->isValidMethod(RESTConstants::SUB_ENDPOINT_ORDERS, $requestMethod)) != RESTConstants::HTTP_OK) {
                throw new APIException($outcome, $endpointPath . '/' . $uri[0]); //Checking if method is allowed for sub endpoint
            }
            switch ($uri[0]) {
                case $this->validSubRequests[RESTConstants::ENDPOINT_CREP][0]:
                    return $this->doOrderRequest($queries);
                //case $this->validSubRequests[RESTConstants::ENDPOINT_CREP][0]:
                    //TBD
            }
        }
        elseif (count($uri) == 3) { //Updating the resource
            if (!ctype_digit($uri[1]) ||  !ctype_digit($uri[2]))
                throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);
            if (($outcome = $this->isValidMethod(RESTConstants::SUB_ENDPOINT_ORDERS, $requestMethod)) != RESTConstants::HTTP_OK) {
                throw new APIException($outcome, $endpointPath . '/' . $uri[0]); //Checking if method is allowed for sub endpoint
            }
            
            $res = array();
            $res['result'] = $this->doUpdateState($uri[1], $uri[2], $payload);
            $res['status'] = RESTConstants::HTTP_OK;
            return $res;
        }
        else
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, $endpointPath);
    }
    
    /**
     * Checks whether the method call is valid for the given resource request/controller.
     * @param string $request the requested resource
     * @param string $method the method to check
     * @return int the HTTP status code indicating whether the method is OK, NOT IMPLEMENTED or NOT ALLOWED on the
     *         requested resource/controller
     */
    public function isValidMethod(string $request, string $method): int
    {
        if (key_exists($request, $this->validMethods) && key_exists($method, $this->validMethods[$request])) {
            return $this->validMethods[$request][$method];
        }
        return RESTConstants::HTTP_METHOD_NOT_ALLOWED;
    }

    protected function doUpdateState(int $employeeNr, int $orderNr, array $payload)
    {
        return (new CompanyModel())->updateState($employeeNr, $orderNr, $payload);
    }

    /**
     * The function handling the retrival of orders with query string on orders
     * @param array $queries filter parameters being passed from the client
     * @return array the collection of resources
     */
    protected function doOrderRequest(array $queries): array
    {
        //Filter set to null at first
        $filter = null;
        if (isset($queries['state'])) {                                 //If the state parameter is set
            $processed = str_replace("-", " ", $queries['state']);
            $filter = array();
            $filter['state'] = preg_split('/[,][\s]*/', $processed);    //Process the string into an array

            //Function for mapping values as are from API to how they would be in the database
            foreach ($filter['state'] as $key => $item) {
                switch ($item) {
                    case 'new':
                        $filter['state'][$key] = 1;
                        break;
                    case 'open':
                        $filter['state'][$key] = 2;
                        break;
                    case 'skis avaliable':
                        $filter['state'][$key] = 3;
                        break;
                    case 'ready to be shipped':
                        $filter['state'][$key] = 4;
                        break;
                }
            }
        }

        //Getting the response
        $res = array();
        $res['result'] = (new CompanyModel())->getOrders($filter);
        if (count($res['result']) > 0) {
            $res['status'] = RESTConstants::HTTP_OK;
        } else {
            throw new APIException(RESTConstants::HTTP_NOT_FOUND, "http://localhost/api/company/customer_rep/orders?state");
        }

        foreach ($res['result'] as $key => $items) { //Mapping over array to replace IDs with readable names
            foreach ($items as $key2 => $item) {
                if ($key2 == 'state_id') {
                    switch ($item) {
                        case 1:
                            $res['result'][$key][$key2] = 'new';
                            break;
                        case 2:
                            $res['result'][$key][$key2] = 'open';
                            break;
                        case 3:
                            $res['result'][$key][$key2] = 'skis avaliable';
                            break;
                        case 4:
                            $res['result'][$key][$key2] = 'ready to be shipped';
                            break;
                    }
                }
            }
        }
        return $res;
    }
}