<?php
require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';

/**
 * Class CustomerEndpoint for customer requests
 */
class CompanyEndpoint extends ResourceController
{
    public function __construct()
    {
        //SETTING ALL ALLOWED METHODS AND REQUESTS HERE
    }

    public function handleRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
    
        //Collection request
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
        }
        /*else if (count($uri) > 1) { //If this is a sub resource request, do what needs to be done here
            //Check if valid method
                //Handle possible error
            //Forward to sub resource request
        }*/
        $res = array();
        return $res; //THIS IS JUST TO STOP INTELLISENSE RAGE; NOT A REAL RETURN
    }
    
    protected function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
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