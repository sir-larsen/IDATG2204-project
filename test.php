<?php

require_once 'controller/OrdersEndpoint.php';
require_once 'controller/CustomerEndpoint.php';
require_once 'db/DB.php';
require_once 'db/AbstractModel.php';
require_once 'db/CustomerModel.php';
require_once 'db/AuthorisationModel.php';
require_once 'BadRequestException.php';
require_once 'DBConstants.php';

//$customer = new CustomerModel;

//$res = $customer->getCollection();

//print_r($res);

//$auth = new AuthorisationModel;

/*$res2 = $auth->isValid();

print_r($res2);
print($res2[0]['token']);*/
//print(true);
//print(false);

//$authCheck = $auth->isValid('d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132', DBConstants::TRANSPORT);

/*if ($authCheck)
    echo "true";
else
    echo "false";*/

$order = new OrdersEndpoint();

print_r($order->handleRequest([], "", "", [], []));

$auth = new AuthorisationModel;
print($auth->isEmployee('d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132'));


$customer = new CustomerEndpoint();

print_r($customer->handleRequest([], "", "", [], []));

$authCustomer = new AuthorisationModel();
print($authCustomer->isValid('544c4686e64cdcdaba07ec71b4940122b0e9cc844d803d6cbc7282e139b08960', DBConstants::CUSTOMER));
