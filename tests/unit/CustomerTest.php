<?php

class CustomerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testHandleRequestAllCustomers() {
        $uri = [];
        $endpointPath = '/customer';
        $requestMethod = RESTConstants::METHOD_GET;
        $queries = array();
        $payload = array();

        $endpoint = new CustomerEndpoint();
        $res = $endpoint->handleRequest( $uri, $endpointPath, $requestMethod, $queries, $payload)['result'];
        $this->tester->assertCount(5, $res);
        $resource = $res[4];
        $this->tester->assertEquals('5', $resource['id']);
        $this->tester->assertEquals('2018-04-27', $resource['start_date']);
        $this->tester->assertEquals('2021-02-14', $resource['end_date']);
        $this->tester->assertEquals('1', $resource['customer_rep']);
    }

    public function testHandleRequestOrder() {
        $uri = explode( '/', "1/2");
        $endpointPath = '/customer';
        $requestMethod = RESTConstants::METHOD_GET;
        $queries = array();
        $payload = array();

        $endpoint = new CustomerEndpoint();
        $res = $endpoint->handleRequest( $uri, $endpointPath, $requestMethod, $queries, $payload)['result'];
        $this->tester->assertCount(1, $res);
        $resource = $res[0];
        $this->tester->assertEquals('2', $resource['order_nr']);
        $this->tester->assertEquals('new', $resource['order_state']);
        $this->tester->assertEquals('1', $resource['customer_id']);
        $this->tester->assertEquals('Maximiliano Zakarias', $resource['customer_rep']);
        $this->tester->assertEquals(null, $resource['total_price']);
        $this->tester->assertEquals('2021-05-10', $resource['date_placed']);
    }
}