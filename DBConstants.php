<?php

/**
 * Class DBConstants for database constants.
 */
class DBConstants
{
    //Different user types
    const EMPLOYEE_CREP     = 'customer_rep'; //Hash id 1 in db
    const EMPLOYEE_SKEEPER  = 'storekeeper';  //Hash id 2 in db
    const EMPLOYEE_PPLANNER = 'prodplanner';  //Hash id 3 in db
    const CUSTOMER          = 'customer';     //Hash id 4 in db
    const TRANSPORT         = 'transporter';    //Hash id 5 in db

    const EMPLOYEES = array('customer_rep', 'storekeeper', 'prodplanner');
}