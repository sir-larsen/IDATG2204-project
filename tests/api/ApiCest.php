<?php
require_once 'Authorisation.php';
class ApiCest
{
    public function _before(ApiTester $I)
    {
    }

    // Testing that the ski collection is properly retrieved
    public function testGetCollection(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('http://localhost/idatg2204-project/public');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            "product_no" => 'integer',
            'url' => 'null',
            'msrpp' => 'string',
            'in_production' => "string",
            'model' => 'string',
            'grip' => 'string',
            'type' => 'string',
            'min_weight' => 'string',
            'max_weight' => 'string',
            'size' => 'string',
            'temp' => 'string'
        ]);
        $I->assertEquals(3, count(json_decode($I->grabResponse())));

    }
    //Testing that the right format is displayed using the "filter by model" endpoint
    public function testPublicWithFilter(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('http://localhost/idatg2204-project/public/model/Endurance');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();

        $I->assertEquals(1, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array('product_no' => 1, 'url' => null, 'msrpp' => '1700', 'in_production' => 'yes', 'model' => 'Endurance',
            'grip' => 'wax', 'type' => 'skate', 'min_weight' => '20', 'max_weight' => '30', 'size' => '135', 'temp' => 'cold'), );
    }


    //Testing that the transporter endpoint is accessible with token
    /*
    public function testTransporterGetCollection(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        Authorisation::setAuthorisationToken($I);
        $I->sendGet('http://localhost/idatg2204-project/transporter');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();

        $I->assertEquals(1, count(json_decode($I->grabResponse())));

    }
*/
    //!!!!!getClient() missing from generated file in Authorisation.php


    //---------------------------------Security Tests---------------------------------------------------------------

    //Testing that transporter is safe from unauthorized access
    public function testTransporterToken(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('http://localhost/idatg2204-project/transporter');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array('error_code' => 403,
            'title' => 'Forbidden',
            'detail' => 'The client is not authorized to perform the requested operation',
            'instance' => "http://localhost/api/v1/"));
    }

    //Testing that customer is safe from unauthorized access
    public function testCustomerToken(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('http://localhost/idatg2204-project/customer');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array('error_code' => 403,
            'title' => 'Forbidden',
            'detail' => 'The client is not authorized to perform the requested operation',
            'instance' => "http://localhost/api/v1/"));
    }

    //Testing that company is safe from unauthorized access
    public function testCompanyToken(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('http://localhost/idatg2204-project/company');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array('error_code' => 403,
            'title' => 'Forbidden',
            'detail' => 'The client is not authorized to perform the requested operation',
            'instance' => "http://localhost/api/v1/"));
    }

}
