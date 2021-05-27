<?php

/**
 * Class RESTConstants class for application constants.
 */
class RESTConstants
{
    const API_URI = 'http://localhost/api/v1';

    // HTTP method names
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    // HTTP status codes
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;

    /*// Defined application endpoints
    const ENDPOINT_DEALERS = 'dealers';
    const ENDPOINT_USEDCARS = 'used-cars';
    const ENDPOINT_REPORT = 'create-report';
    const ENDPOINT_REPORT_DEALER_STOCK = 'dealer-stock';
    const ENDPOINT_ID = '{id}';*/
    //const ENDPOINT_ORDERS = 'orders';
    const ENDPOINT_COMPANY = 'company';
    const ENDPOINT_CUSTOMER = 'customer';
    const ENDPOINT_TRANSPORTER = 'transporter';
    const ENDPOINT_PUBLIC = 'public';

    const ENDPOINT_CREP     = 'customer_rep';
    const ENDPOINT_SKEEPER  = 'storekeeper';
    const ENDPOINT_PPLANNER = 'production_planner';


    // Defined database errors
    const DB_ERR_ATTRIBUTE_MISSING = 1;
    const DB_ERR_FK_INTEGRITY = 2;

    // Defined foreign key violations
    const DB_FK_CUSTOMER = 1001;

}
