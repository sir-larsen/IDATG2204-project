<?php
require_once 'RequestHandler.php';
REQUIRE_ONCE 'CustomerEndpoint.php';
//require_once 'DealersEndpoint.php';
//require_once 'UsedCarsEndpoint.php';
//require_once 'ReportController.php';
require_once 'OrdersEndpoint.php';
require_once 'CompanyEndpoint.php';
require_once 'RESTConstants.php';
require_once 'db/AuthorisationModel.php';
require_once 'errors.php';

/**
 * Class APIController this is the main controller for the API - it is just a dispatcher forwarding the requests to
 *       the DealersEndpoint, UsedCarsEndpoint, or ReportController depending on the what endpoint is addressed
 */
class APIController extends RequestHandler
{
    /**
     * The constructor defines the valid requests to be the dealers, used cars and report controller endpoints.
     * @see RequestHandler
     */
    public function __construct()
    {
        parent::__construct();
        $this->validRequests[] = RESTConstants::ENDPOINT_COMPANY;
        $this->validRequests[] = RESTConstants::ENDPOINT_CUSTOMER;
        $this->validRequests[] = RESTConstants::ENDPOINT_TRANSPORTER;
        $this->validRequests[] = RESTConstants::ENDPOINT_PUBLIC;
        //$this->validRequests[] = RESTConstants::ENDPOINT_ORDERS;
    }

    

    /**
     * Verifies that the request contains a valid authorisation token.
     * @param string $token the authorisation token to be verified
     * @param string $userType the type of user to checked against
     * @param string $endpointPath the request endpoint
     * @throws APIException with the code set to HTTP_FORBIDDEN if the token is not valid
     */
    public function authorise(string $token, string $userType, string $endpointPath) {
        if (!(new AuthorisationModel())->isValid($token, $userType)) {
            throw new APIException(RESTConstants::HTTP_FORBIDDEN, $endpointPath);
        }
        return true;
    }

    /**
     * Verifies that the request contains a valid authorisation token.
     * @param string $token the authorisation token to be verified
     * @param string $endpointPath the request endpoint
     * @throws APIException with the code set to HTTP_FORBIDDEN if the token is not valid
     */
    public function authoriseEmployee(string $token, string $endpointPath) {
        if (!(new AuthorisationModel())->isEmployee($token)) {
            throw new APIException(RESTConstants::HTTP_FORBIDDEN, $endpointPath);
        }
    }

    /**
     * The main function handling the client request to the api. The call is forwarded to the implemented endpoint
     * controllers
     * @throws APIException as described in the superclass
     * @see RequestHandler
     * @see DealersEndpoint for the dealers-controller endpoint controller ////ENDRE PÅ HELE DENNE KOMMENTAREN
     * @see UsedCarsEndpoint for the used-cars endpoint controller         ////
     * @see ReportController for the report-generator endpoint controller
     */
    public function handleRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array
    {
        //Checking if the request is valid here
        $endpointUri = $uri[0];
        if (!$this->isValidRequest($endpointUri)) {
            throw new APIException(RESTConstants::HTTP_NOT_FOUND, $endpointPath);
        }

        $endpointPath .= '/' . $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_COMPANY:
                $endpoint = new CompanyEndpoint();
                break;
            case RESTConstants::ENDPOINT_CUSTOMER:
                $endpoint = new CustomerEndpoint();
                break;
        }
        return $endpoint->handleRequest(array_slice($uri, 1), $endpointPath, $requestMethod, $queries, $payload);
    }
}
