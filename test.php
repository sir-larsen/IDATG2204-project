<?php

require_once 'db/DB.php';
require_once 'db/AbstractModel.php';
require_once 'db/CustomerModel.php';
require_once 'BadRequestException.php';

$customer = new CustomerModel;

$res = $customer->getCollection();

//print_r($res);

$auth = new AuthorisationModel;

$res2 = $auth->isValid();

print_r($res2);