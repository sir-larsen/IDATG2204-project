<?php
require_once 'controller/APIController.php';
require_once 'controller/APIException.php';
require_once 'errors.php';
header('Content-Type: application/json');

//Parse the request parameters
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
if (!isset($queries['request'])) {
    http_response_code(RESTConstants::HTTP_NOT_FOUND);
    echo json_encode(generateErrorResponseContent(RESTConstants::HTTP_NOT_FOUND, '/'));
    return;
}

$uri = explode( '/', $queries['request']);
unset($queries['request']);

//print_r($uri);

$requestMethod = $_SERVER['REQUEST_METHOD'];

$content = file_get_contents('php://input');
if (strlen($content) > 0) {
    $payload = json_decode($content, true);
} else {
    $payload = array();
}

$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : ''; //Reading the hash from the client trying to access

print($token);

//print($uri[0]);
 
//Handle the request
$controller = new APIController();
try {
    print($uri[0]);
    $employeeType = ''; //For keeping track of which type of employee to restrict which endpoints
    switch ($uri[0]) {
        case RESTConstants::ENDPOINT_CUSTOMER:
            $controller->authorise($token, DBConstants::CUSTOMER, RESTConstants::API_URI . '/');
            //print("INNICUSTOMER");
            break;
        case RESTConstants::ENDPOINT_TRANSPORTER:
            //print("INNI TRANSPORTER");
            $controller->authorise($token, DBConstants::TRANSPORT, RESTConstants::API_URI . '/');
            break;
        case RESTConstants::ENDPOINT_COMPANY:
            //print("INNI COMPANY");
            $controller->authoriseEmployee($token, RESTConstants::API_URI . '/');
            $employeeType = (new AuthorisationModel())->getEmployeeType($token);
            break;
    }
    //HERE SUPPOSED TO READ THE ENDPOINTS AND AUTHORIZE, TBD!!! REMEMBER TO DO
    $res = $controller->handleRequest($uri, RESTConstants::API_URI, $requestMethod, $queries, $payload, $employeeType);
    //print_r($res);
    http_response_code($res['status']);
    if (isset($res['result']))  {
        //echo json_encode($res['result']);
        print(json_encode($res['result']));
    }
} catch (APIException $e){
    http_response_code($e->getCode());
    echo json_encode(generateErrorResponseContent($e->getCode(), $e->getInstance(), $e->getDetailCode(), $e));
} catch (BadRequestException $e){
    $resp = generateDBErrorResponseContent($e->getCode(), $e->getInstance(), $e->getDetailCode());
    http_response_code($resp['error_code']);
    echo json_encode($resp);
} catch (Throwable $e) {
    http_response_code(RESTConstants::HTTP_INTERNAL_SERVER_ERROR);
    echo json_encode(generateDBErrorResponseContent(RESTConstants::HTTP_INTERNAL_SERVER_ERROR, '/', -1));
}