<?php
require_once 'DB.php';
require_once 'AbstractModel.php';
require_once 'BadRequestException.php';

//TEST CLASS FOR TABLE
/**
 * Class CustomerModel for accessing customer data in the database
 */
class CustomerModel extends AbstractModel {
    public function __construct()
    {
        parent::__construct();
    }

    /**
   * Returns the collection of resources from the database.
   * @param array $query an optional set of conditions that the retrieved
   *              resources need to meet - e.g., array('counties' => array('...', ...)) would
   *              mean that only resources having make = Ford would be returned.
   * @return array an array of associative arrays of resource attributes. The
   *               array will be empty if there are no resources to be returned.
   * @throws BadRequestException in the case the request from the client is badly formatted or violates application
   *         or database constraints.
   * @throws BadRequestException
   */
    function getCollection(?array $query = null): array
    {
        $res = [];

        $query = 'SELECT id, start_date, end_date, customer_rep FROM customer';

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('id' => intval($row['id']), 'start_date' => $row['start_date'], 'end_date' => $row['end_date'], 'customer_rep' => $row['customer_rep']);
        }
        return $res;
    }

    /*function retrieveOrderSince(array $filter): ?array {

        $res = array();

        //$query = 'SELECT '

    }*/
}