<?php

require_once 'RESTConstants.php';

class AuthorisationTest extends \Codeception\Test\Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidAuthorisation() {
        // TODO: Insert a valid token
        (new APIController())->authorise('token', '/');
    }

    public function testInvalidAuthorisation() {
        try {
            (new APIController())->authorise('', '/');
            $this->tester->fail('APIException expected');
        } catch (APIException $e) {
            $this->tester->assertEquals(RESTConstants::HTTP_FORBIDDEN, $e->getCode());
        }
    }
}
