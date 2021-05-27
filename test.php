<?php

require_once 'controller/OrdersEndpoint.php';
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
$authCheck = $auth->isEmployee('7f38212946ddbd7aadba90192887c5538328bb77bf3756504a1e538226fa8f51');
if ($authCheck)
    echo "true\n";
else
    echo "false\n";

$authCheck = $auth->isEmployee('4b36a056eebfab7e4bbb26a278309812f55623b9675d4b4e9345f3fbf89e71d3');
if ($authCheck)
    echo "true\n";
else
    echo "false\n";

$authCheck = $auth->isEmployee('9d34402491a7e00f0ed216ed2f6ac63b2848ce41ad17a65bde2fffd47f7445c2');
if ($authCheck)
    echo "true\n";
else
    echo "false\n";

$authCheck = $auth->isEmployee('544c4686e64cdcdaba07ec71b4940122b0e9cc844d803d6cbc7282e139b08960');
if ($authCheck)
    echo "true\n";
else
    echo "false\n";

$authCheck = $auth->isEmployee('d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132');
if ($authCheck)
    echo "true\n";
else
    echo "false\n";

echo "\n\n";

$authCheck = $auth->isValid('7f38212946ddbd7aadba90192887c5538328bb77bf3756504a1e538226fa8f51', DBConstants::EMPLOYEE_CREP);
if ($authCheck)
    echo "true\n";
else
    echo "false\n";

$authCheck = $auth->isValid('7f38212946ddbd7aadba90192887c5538328bb77bf3756504a1e538226fa8f51', DBConstants::EMPLOYEE_CREP);
if ($authCheck)
    echo "true\n";
else
    echo "false\n";