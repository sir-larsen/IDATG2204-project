<?php
require_once 'DB.php';
require_once 'AbstractModel.php';
require_once 'BadRequestException.php';

//TEST CLASS FOR TABLE
/**
 * Class PublicModel for accessing skis data in the database
 */
class TransporterModel extends AbstractModel
{
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

        //Query to get all ski-models and exchanging attribute Id's for their actual names
        $query = 'SELECT orders.order_nr, order_state.state, orders.parent_id, orders.total_price, orders.customer_id,
       employee.name AS customer_Rep, orders.date_placed
        FROM orders 
        INNER JOIN order_state ON orders.state_id = order_state.id
        INNER JOIN employee ON orders.customer_rep = employee.nr
        WHERE orders.state_id = 4';

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('order_nr' => intval($row['order_nr']), 'state' => $row['state'], 'parent_id' => $row['parent_id'],
                'total_price' => $row['total_price'], 'customer_id' => $row['customer_id'], 'customer_rep' => $row['customer_Rep'],
                'date_placed' => $row['date_placed'],);
        }

        foreach ($res as $key => $value) {

            if ($value['parent_id'] == null) {
                $res[$key]['parent_id'] = 'Not a sub-order';
            }
            if ($value['total_price'] == null) {
                $res[$key]['total_price'] = 'No price information received';

            }
        }

        return $res;
    }
}

