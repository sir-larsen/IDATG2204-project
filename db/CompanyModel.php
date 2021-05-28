<?php
require_once 'DB.php';
require_once 'BadRequestException.php';

/**
 * Class CompanyModel class for accessing data to do with company in the database
 */
class CompanyModel extends DB {
    public function __construct()
    {
        parent::__construct();
    }

   /**
   * Returns the orders in regards to the filter set
   * @param array $query an optional set of conditions that the retrieved
   *              resources need to meet - e.g., array('state' => array('new', ...)) would
   *              mean that only resources having state = 'new' would be returned.
   * @return array an array of associative arrays of resource attributes. The
   *               array will be empty if there are no resources to be returned.
   * @throws BadRequestException in the case the request from the client is badly formatted or violates application
   *         or database constraints.
   * @throws BadRequestException
   */
    function getOrders(array $filter): array
    {
        $res = array();

        $query = 'SELECT * FROM orders';
        if ($filter['state']) {
            $query .= ' WHERE state_id IN (:p0';
            for ($i = 1; $i < count($filter['state']); $i++) {
                $query .= ',:p' . $i;
            }
            $query .= ')';
            $stmt = $this->db->prepare($query);
            for ($i = 0; $i < count($filter['state']); $i++) {
                $stmt->bindValue(':p' . $i, $filter['state'][$i]);
            }
            $stmt->execute();
        } else {
            $stmt = $this->db->query($query);
        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('order_nr' => intval($row['order_nr']), 'state_id' => intval($row['state_id']), 'parent_id' => intval($row['parent_id']), 
                           'total_price' => intval($row['total_price']), 'customer_id' => intval($row['customer_id']), 'customer_rep' => intval($row['customer_rep']),
                           'date_placed' => $row['date_placed']);
        }
        return $res;
    }

    
    function updateState(int $employeeNr, int $orderNr, array $resource): array
    {
        $oldState = $this->getState($orderNr);

        $mod = array();
        switch ($resource['new_state']) {
            case 'new':
                $mod['new_state'] = 1;
                break;
            case 'open':
                $mod['new_state'] = 2;
                break;
            case 'skis avaliable':
                $mod['new_state'] = 3;
                break;
            case 'ready to be shipped':
                $mod['new_state'] = 4;
                break;
        }

        if ($oldState['state_id'] == $mod['new_state']) {
            throw new APIException(RESTConstants::HTTP_BAD_REQUEST, "New state cannot be the same as old one");
        }

        $this->db->beginTransaction();
        $rec = $this->verifyStatePayload($resource);
        $rec2 = $this->verifyEmployeeNr($employeeNr);
        $rec3 = $this->verifyOrderNr($orderNr);
        if ($rec['code'] != RESTConstants::HTTP_OK || $rec2['code'] != RESTConstants::HTTP_OK || $rec3['code'] != RESTConstants::HTTP_OK) {
            $this->db->rollBack(); print("\nINSIDE ROLLBACK\n");
            if (isset($rec['detailCode'])) {
                print("INNI COCKC");
                throw new BadRequestException($rec['code'], $rec['detailCode']);
            } else {
                print("INNI COCKC2");
                throw new BadRequestException($rec['code']);
            }
        }
        $res = array();
        $query = 'UPDATE orders SET state_id = :state_id, customer_rep = :customer_rep WHERE order_nr = :order_nr;';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':state_id', $mod['new_state']);
        $stmt->bindValue(':customer_rep', $employeeNr);
        $stmt->bindValue(':order_nr', $orderNr);
        $stmt->execute();

        $res['status'] = RESTConstants::HTTP_OK;
        $res['result'] = array();
        $res['result']['order_nr'] = $orderNr;
        $res['result']['customer_rep'] = $employeeNr;
        $res['result']['state'] = $resource['new_state'];
        $this->db->commit();


        //Placing order_history
        $this->placeOrderHistory($orderNr, $employeeNr, $oldState['state_id']);

        return $res;
    }

    function placeOrderHistory(int $orderNr, int $employeeNr, int $oldState) {
        $this->db->beginTransaction();

        $query = 'INSERT INTO order_history (order_nr, employee, old_state)
        VALUES (:order_nr, :employee, :old_state)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_nr', $orderNr);
        $stmt->bindValue(':employee', $employeeNr);
        $stmt->bindValue(':old_state', $oldState);
        $stmt->execute();

        $this->db->commit();
    }

    function verifyOrderNr(int $nr): array
    {
        $res = array();

        if (!$this->isOrderExisting($nr)) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
            return $res;
        }
        $res['code'] = RESTConstants::HTTP_OK;
        return $res;
    }

    function isOrderExisting(int $nr): bool {
        $query = 'SELECT COUNT(*) FROM orders WHERE order_nr = :nr';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nr', $nr);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }

  /**
   * Checks the format of the resource array to see that it satisfy the database schema. The test will only verify the
   * presence and type of database columns, additional keys passed will be ignored.
   * @param array $payload the resource represented as an associative array of the format
   * @return array an array of the form array('code' => integer, 'detailCode' => integer) where the code is referring to
   *                       one of the types of DB error. detail will hold the code of the dealer-county FK error if
   *                       the name of the county does not match a known county in the database.
   * @see RESTConstants.
   */
    function verifyStatePayload(array $payload): array
    {
        $res = array();

        if (!array_key_exists('new_state', $payload)) {
            $res['code'] = RESTConstants::DB_ERR_ATTRIBUTE_MISSING;
            return $res;
        }

        if (!$this->isStateExisting($payload['new_state'])) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
        }

        $res['code'] = RESTConstants::HTTP_OK;
        return $res;
    }

    function verifyEmployeeNr(int $nr): array {
        $res = array();

        if (!$this->isEmployeeExisting($nr)) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
            return $res;
        }
        $res['code'] = RESTConstants::HTTP_OK;
        return $res;
    }

    function isEmployeeExisting(int $nr): bool {
        $query = 'SELECT COUNT(*) FROM employee WHERE nr = :nr';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nr', $nr);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }

    function getState(int $orderNr): array {
        $query = 'SELECT state_id FROM orders WHERE order_nr = :nr';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nr', $orderNr);
        $stmt->execute();

        $res = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res = array('state_id' => intval($row['state_id']));
        }
        return $res;
    }

    function isStateExisting(string $state): bool
    {
        $query = 'SELECT COUNT(*) FROM order_state WHERE state = :state';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':state', $state);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }
}