<?php
require_once 'RequestHandler.php';

abstract class ResourceController extends RequestHandler
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The main function handling the client request to the resource endpoint. Collection requests are forwarded to the
     * handleCollectionRequest(), while resource requests are forwarded to the handleResourceRequest().
     * @throws APIException as described in the superclass
     * @throws BadRequestException as described in the superclass
     * @see RequestHandler::handleRequest()
     * @see handleCollectionRequest for the handling og collection requests
     * @see handleResourceRequest for the handling of resource requests
     */
    //public abstract function handleRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array;
    /*{
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
        /*$res = array();
        return $res; //THIS IS JUST TO STOP INTELLISENSE RAGE; NOT A REAL RETURN
    }*/
}