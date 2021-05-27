<?php

require_once 'controller/OrdersEndpoint.php';
require_once 'db/DB.php';
require_once 'db/AbstractModel.php';
require_once 'db/CustomerModel.php';
require_once 'db/AuthorisationModel.php';
require_once 'BadRequestException.php';
require_once 'DBConstants.php';
require_once 'controller/CompanyEndpoint.php';
require_once 'db/PublicModel.php';
require_once 'controller/PublicEndpoint.php';
require_once 'db/TransporterModel.php';

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

//$order = new OrdersEndpoint();

//print_r($order->handleRequest([], "", "", [], []));

/*$auth = new AuthorisationModel();

$cock = $auth->getEmployeeType('9d34402491a7e00f0ed216ed2f6ac63b2848ce41ad17a65bde2fffd47f7445c2');
print($cock . "\n\n");
print_r(DBConstants::EMPLOYEES);
print(DBConstants::EMPLOYEES[0]);*/

//$cust = new CompanyEndpoint('prodplanner');
//print($cust->employeeType);
//$auth = new AuthorisationModel;
//print($auth->isEmployee('d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132'));

/*
$public = new PublicModel;

$res = $public->getCollection();

foreach ($res as $key => $value){

    if ($value['in_production'] == 0){
        $res[$key]['in_production'] = 'yes';
    }else{
        $res[$key]['in_production'] = 'no';
    }

}


print_r($res);
*/
/*
$public = new PublicEndpoint();

$res = $public->handleCollectionRequest("", "", [], []);
print_r($res);
*/
/*
$public = new PublicModel();

$res = $public->getGrip(null,'intelligrip');

print_r($res);
*/

//$transporter = new TransporterModel();

//$res = $transporter->getCollection();

//print_r($res);

$auth = new AuthorisationModel();
print($auth->isValid('d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132', DBConstants::TRANSPORT));
