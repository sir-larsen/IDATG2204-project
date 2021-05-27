<?php
require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';
require_once 'db/PublicModel.php';
/**
 * To display all skis:
 *  /api/public
 *
 * To filter based on model
 * /api/public/model/{:model-name}
 *
 * To filter based on grip:
 * /api/public/grip/{:grip-name}
 *
 */


/**
 * Class PublicEndpoint for public requests
 */
class PublicEndpoint extends ResourceController
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
        else if (count($uri) > 1) {

            if($uri[0] == 'model'){
                return $this->handleCollectionModel($endpointPath, $requestMethod, $queries, $payload, $uri[1]);
            }

            if($uri[0] == 'grip'){
                return $this->handleCollectionGrip($endpointPath, $requestMethod, $queries, $payload, $uri[1]);
            }


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

    public function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $model = new PublicModel();


        $res = array();
        try {
            switch ($requestMethod) {
                case RESTConstants::METHOD_GET:
                    $res['result'] = $this->doRetrieveCollection($queries);
                    if (count($res['result']) > 0) {
                        $res['status'] =  RESTConstants::HTTP_OK;
                    } else {
                        throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath);
                    }
                    break;
            }
        } catch (BadRequestException $e) {
            throw new BadRequestException($e->getCode(), $e->getDetailCode(), $endpointPath, $e->getMessage(), $e);
        }
        return $res;
    }


    protected function handleCollectionModel(string $endpointPath, string $requestMethod, array $queries, array $payload, string $skimodel): array
    {

        $model = new PublicModel();

        $res = array();
        try {
            switch ($requestMethod) {
                case RESTConstants::METHOD_GET:
                    $res['result'] = $this->doRetrieveModel($queries, $skimodel);
                    if (count($res['result']) > 0) {
                        $res['status'] =  RESTConstants::HTTP_OK;
                    } else {
                        throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath);
                    }
                    break;
            }
        } catch (BadRequestException $e) {
            throw new BadRequestException($e->getCode(), $e->getDetailCode(), $endpointPath, $e->getMessage(), $e);
        }
        return $res;
    }



    protected function handleCollectionGrip(string $endpointPath, string $requestMethod, array $queries, array $payload, string $grip): array
    {

        $model = new PublicModel();

        $res = array();
        try {
            switch ($requestMethod) {
                case RESTConstants::METHOD_GET:
                    $res['result'] = $this->doRetrieveGrip($queries, $grip);
                    if (count($res['result']) > 0) {
                        $res['status'] =  RESTConstants::HTTP_OK;
                    } else {
                        throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath);
                    }
                    break;
            }
        } catch (BadRequestException $e) {
            throw new BadRequestException($e->getCode(), $e->getDetailCode(), $endpointPath, $e->getMessage(), $e);
        }
        return $res;
    }



    protected function doRetrieveCollection(array $queries): array
    {
        $filter = null;
        return (new PublicModel())->getCollection($filter);
    }

    protected function doRetrieveModel(array $queries, string $model): array
    {
        $filter = null;
        return (new PublicModel())->getModel($filter, $model);
    }

    protected function doRetrieveGrip(array $queries, string $grip): array
    {
        $filter = null;
        return (new PublicModel())->getGrip($filter, $grip);
    }


    protected function handleSubRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $res = array();
        return $res;
    }
}
