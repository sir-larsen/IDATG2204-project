<?php
require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';
require_once 'db/TransporterModel.php';

/**
 * To display all orders ready for pickup:
 *  /api/transporters
 *
 * Update a shipments state from ready for pickup to picked up:
 * /api/transporter/pickedup/{:shipment_nr}
 *
 */

/**
 * Class OrdersEndpoint implementing the orders endpoint controller
 */
class TransporterEndpoint extends ResourceController
{
    public function __construct()
    {
        //SETTING ALL THE ALLOWED METHODS AND REQUESTS HERE
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

            if($uri[0] == 'pickedup') {

                return $this->handleCollectionPickup($endpointPath, $requestMethod, $queries, $payload, $uri[1]);

            }else{
                throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath . '/' . implode('/', $uri));
            }
        }
        else{
            throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath . '/' . implode('/', $uri));
        }
        $res = array();
        return $res;
    }

    protected function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $model = new TransporterModel();


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

    protected function handleCollectionPickup(string $endpointPath, string $requestMethod, array $queries, array $payload, string $id): array
    {
        $model = new TransporterModel();


        $res = array();
        try {
            switch ($requestMethod) {
                case RESTConstants::METHOD_GET:
                    $res['result'] = $this->doUpdateState($queries, $id);
                    if (count($res['result']) > 0) {
                        $res['status'] =  RESTConstants::HTTP_OK;
                    } else {
                        $res['status'] =  RESTConstants::HTTP_OK;

                        throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath);
                    }
                    break;
            }
        } catch (BadRequestException $e) {
            throw new BadRequestException($e->getCode(), $e->getDetailCode(), $endpointPath, $e->getMessage(), $e);
        }

        return $res;
    }

    protected function handleSubRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $res = array();
        return $res;
    }

    protected function doRetrieveCollection(array $queries): array
    {
        $filter = null;
        return (new TransporterModel())->getCollection($filter);
    }

    protected function doUpdateState(array $queries, string $id): array
    {


        $filter = null;
        return (new TransporterModel())->updateShipment($filter, $id);
    }
}