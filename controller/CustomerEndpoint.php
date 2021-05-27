<?php
require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'errors.php';
require_once 'db/CustomerModel.php';


/**
 * Class CustomerEndpoint implementing the customers endpoint controller.
 */
class CustomerEndpoint extends ResourceController {


    public function __construct() {

        parent::__construct();
        //$this->validRequests[] = RESTConstants::ENDPOINT_CUSTOMER;

        // Valid collection method calls vs implementation status
        //$this->validMethods[''] = array();
        //$this->validMethods[''][RESTConstants::METHOD_GET] = RESTConstants::HTTP_OK;
        //$this->validMethods[''][RESTConstants::METHOD_POST] = RESTConstants::HTTP_NOT_IMPLEMENTED;
        //$this->validMethods[''][RESTConstants::METHOD_DELETE] = RESTConstants::HTTP_NOT_IMPLEMENTED;

        // Valid resource method calls vs implementation status


    }

    public function handleRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
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

    protected function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        // TODO: Implement handleCollectionRequest() method.
    }

    protected function handleSubRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        // TODO: Implement handleSubRequest() method.
    }

    /**
     * @throws BadRequestException as other request handling methods
     * @see ResourceController::doRetrieveResource
     */
    protected function retrieveOrderSince(string $filter): ?array {
        //return (new CustomerModel()->retrieveOrderSince($filter));
    }


}