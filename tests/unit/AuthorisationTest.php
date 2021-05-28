<?php

require_once 'RESTConstants.php';
require_once 'DBConstants.php';
require_once 'controller/APIController.php';

class AuthorisationTest extends \Codeception\Test\Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidAuthorisation() {
        (new APIController())->authorise('544c4686e64cdcdaba07ec71b4940122b0e9cc844d803d6cbc7282e139b08960', RESTConstants::ENDPOINT_CUSTOMER, '/');
    }

    public function testInvalidAuthorisation() {
        try {
            (new APIController())->authorise('', RESTConstants::ENDPOINT_CUSTOMER, '/');
            $this->tester->fail('APIException expected');
        } catch (APIException $e) {
            $this->tester->assertEquals(RESTConstants::HTTP_FORBIDDEN, $e->getCode());
        }
    }

    public function testValidGetEmployeeType() {
        (new APIController())->authoriseEmployee('7f38212946ddbd7aadba90192887c5538328bb77bf3756504a1e538226fa8f51', '/');
    }

    public function testInvalidGetEmployeeType() {
        try {
            (new APIController())->authoriseEmployee('', '/');
            $this->tester->fail('APIException expected');
        } catch (APIException $e) {
            $this->tester->assertEquals(RESTConstants::HTTP_FORBIDDEN, $e->getCode());
        }
    }
}
