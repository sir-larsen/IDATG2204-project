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
    }

    public function handleRequest(array $uri, string $endpointPath, string $requestMethod, array $queries, array $payload): array {
        if (count($uri) == 0) {
            //Check if method is valid
            //If not valid throw error
            //handle the collection request-- Which means actually getting it DOCOLLECTIONREQUEST
            return $this->handleCollectionRequest($endpointPath, $requestMethod, $queries, $payload);
        } elseif (count($uri) > 1) {
            if (!ctype_digit($uri[0])) {
                throw new BadRequestException(RESTConstants::HTTP_BAD_REQUEST, "Missing customer id");
            } else {
                switch ($uri[1]) {
                    case ctype_digit($uri[1]):
                        return $this->retrieveOrder($uri[1]);
                    case "orders":
                        return $this->retrieveOrderSince();
                    case "place_order":
                        return $this->placeOrder();
                    case "cancel_order":
                        return $this->cancelOrder($uri[2]);

                    default:
                        return $res['status'] = RESTConstants::HTTP_NOT_FOUND;
                }
            }
        } else {
            throw new BadRequestException(RESTConstants::HTTP_BAD_REQUEST, "No such endpoint as requested");
        }
    }

    protected function handleCollectionRequest(string $endpointPath, string $requestMethod, array $queries, array $payload): array {
        return (new CustomerModel())->getCollection();
    }

    /**
     * @throws BadRequestException as other request handling methods
     * @see CustomerModel::retrieveOrder()
     */
    protected function retrieveOrder(string $order): ?array {
        return (new CustomerModel())->retrieveOrder($order);
    }

    /**
     * @throws BadRequestException as other request handling methods
     * @see CustomerModel::retrieveOrderSince()
     */
    protected function retrieveOrderSince(): ?array {
        return (new CustomerModel())->retrieveOrderSince();
    }

    /**
     * @throws BadRequestException as other request handling methods
     * @see CustomerModel::placeOrder()
     */
    protected function placeOrder(): ?array {
        return (new CustomerModel())->placeOrder();
    }

    /**
     * @throws BadRequestException as other request handling methods
     * @see CustomerModel::cancelOrder()
     */
    protected function cancelOrder(string $order): ?array {
        return (new CustomerModel())->cancelOrder($order);
    }
}