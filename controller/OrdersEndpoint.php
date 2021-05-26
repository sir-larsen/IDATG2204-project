<?php
require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';
//require_once 'db/DealerModel.php';

/**
 * Class OrdersEndpoint implementing the orders endpoint controller
 */
class OrdersEndpoint extends ResourceController
{
    public function __construct()
    {
        //SETTING ALL THE ALLOWED METHODS AND REQUESTS HERE
    }

    protected function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $res = array();
        $res['cock'] = 5;
        $res['balls'] = 10;
        $res['status'] = RESTConstants::HTTP_OK;
        
        return $res;
    }

    protected function handleSubRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        $res = array();
        return $res;
    }
}