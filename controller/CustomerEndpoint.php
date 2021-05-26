<?php
require_once 'RESTConstants.php';
require_once 'ResourceController.php';
require_once 'Errors.php';
require_once 'db/CustomerModel.php';

/**
 * Class CustomerEndpoint implementing the customer endpoint controller
 */
class CustomerEndpoint extends ResourceController {

    public function __construct() {
        parent::__construct();
        $this->validRequests[] = RESTConstants::ENDPOINT_CUSTOMER;

        // Valid collection method calls vs implementation status
        $this->validMethods['' ][RESTConstants::METHOD_GET] = RESTConstants::HTTP_OK;
        $this->validMethods[''][RESTConstants::METHOD_POST] = RESTConstants::HTTP_NOT_IMPLEMENTED;
        $this->validMethods[''][RESTConstants::METHOD_DELETE] = RESTConstants::HTTP_NOT_IMPLEMENTED;

        // Valid resource method calls vs implementation status
        $this->validMethods[RESTConstants::ENDPOINT_CUSTOMER][RESTConstants::METHOD_GET] = RESTConstants::HTTP_OK;
        $this->validMethods[RESTConstants::ENDPOINT_CUSTOMER][RESTConstants::METHOD_POST] = RESTConstants::HTTP_NOT_IMPLEMENTED;
        $this->validMethods[RESTConstants::ENDPOINT_CUSTOMER][RESTConstants::METHOD_DELETE] = RESTConstants::HTTP_NOT_IMPLEMENTED;
    }

    protected function doRetrieveCollection(array $queries): array
    {
        // TODO: Implement doRetrieveCollection() method.
    }

    protected function doRetrieveResource(int $id): ?array
    {
        // TODO: Implement doRetrieveResource() method.
    }

    protected function doUpdateResource(array $payload)
    {
        // TODO: Implement doUpdateResource() method.
    }

    protected function doCreateResource(array $payload): array
    {
        // TODO: Implement doCreateResource() method.
    }

    protected function doDeleteResource(int $id)
    {
        // TODO: Implement doDeleteResource() method.
    }
}