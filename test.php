<?php

require_once 'db/DB.php';
require_once 'db/AbstractModel.php';
require_once 'db/CustomerModel.php';
require_once 'db/AuthorisationModel.php';
require_once 'BadRequestException.php';
require_once 'DBConstants.php';

$customer = new CustomerModel;

$res = $customer->getCollection();

//print_r($res);

$auth = new AuthorisationModel;

/*$res2 = $auth->isValid();

print_r($res2);
print($res2[0]['token']);*/
//print(true);
print(false);

$authCheck = $auth->isValid('d8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132', DBConstants::TRANSPORT);

if ($authCheck)
    echo "true";
else
    echo "false";