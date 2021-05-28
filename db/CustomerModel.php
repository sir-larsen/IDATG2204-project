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
        $res = array();

        $query = 'SELECT id, start_date, end_date, customer_rep FROM customer';

        $stmt = $this->db->query($query);

        $res['status'] = RESTConstants::HTTP_OK;
        $res['result'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res['result'][] = array('id' => intval($row['id']), 'start_date' => $row['start_date'], 'end_date' => $row['end_date'], 'customer_rep' => $row['customer_rep']);
        }
        return $res;
    }

    function retrieveOrder(string $order): ?array {

        $res = array();

        $query = "SELECT orders.order_nr, order_state.state, orders.customer_id, employee.name AS customer_rep, orders.total_price, orders.date_placed
                    FROM orders
                    INNER JOIN order_state ON order_state.id = orders.state_id
                    INNER JOIN employee ON employee.nr = orders.customer_rep
                    WHERE orders.order_nr = '" . $order . "'";

        $stmt = $this->db->query($query);

        $res['status'] = RESTConstants::HTTP_OK;
        $res['result'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res['result'][] = array('order_nr' => intval($row['order_nr']), 'order_state' => $row['state'],
                'customer_id' => $row['customer_id'], 'customer_rep' => $row['customer_rep'],
                'total_price' => $row['total_price'], 'date_placed' => $row['date_placed']);
        }

        return $res;
    }

    function retrieveOrderSince(): ?array {

        $res = array();
        $server_uri = array();

        parse_str($_SERVER['QUERY_STRING'], $server_uri);

        if (isset($server_uri['since'])) {
            $filter = $server_uri['since'];

            $query = "SELECT orders.order_nr, order_state.state, orders.customer_id, employee.name AS customer_rep, orders.total_price, orders.date_placed
                        FROM orders
                        INNER JOIN order_state ON order_state.id = orders.state_id
                        INNER JOIN employee ON employee.nr = orders.customer_rep
                        WHERE orders.date_placed > '" . $filter . "'";

            $stmt = $this->db->query($query);

            $res['status'] = RESTConstants::HTTP_OK;
            $res['result'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res['result'][] = array('order_nr' => intval($row['order_nr']), 'order_state' => $row['state'],
                    'customer_id' => $row['customer_id'], 'customer_rep' => $row['customer_rep'],
                    'total_price' => $row['total_price'], 'date_placed' => $row['date_placed']);
            }

        } else {
            $res['status'] = RESTConstants::HTTP_BAD_REQUEST;
            $res['result'] = "Missing since parameter: ?since{:yyyy-mm-dd}";
        }

        return $res;
    }

    function placeOrder(): ?array {

        $this->db->beginTransaction();
        $rec = $this->verifyPayload($_POST, true);
        if ($rec['code'] != RESTConstants::HTTP_OK) {
            $this->db->rollBack();
            if (isset($rec['detailCode'])) {
                throw new BadRequestException($rec['code'], $rec['detailCode']);
            } else {
                throw new BadRequestException($rec['code']);
            }
        }

        $res = array();
        $query = 'INSERT INTO orders (state_id, parent_id, total_price, customer_id, customer_rep, date_placed)
                    VALUES (:state_id, :parent_id, :total_price, :customer_id, :customer_rep, curdate())';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':state_id', $_POST['state_id']);
        $stmt->bindValue(':parent_id', $_POST['parent_id']);
        $totalCost = $this->totalCost($_POST['model'], $_POST['quantity']);
        $stmt->bindValue(':total_price',$totalCost);
        $stmt->bindValue(':customer_id', $_POST['customer_id']);
        $stmt->bindValue(':customer_rep', $_POST['customer_rep']);
        $stmt->execute();

        $id = intval($this->db->lastInsertId());

        $res['status'] = RESTConstants::HTTP_OK;
        $res['result'] = array();
        $res['result']['id'] = $id;
        $res['result']['state_id'] = $_POST['state_id'];
        $res['result']['parent_id'] = $_POST['parent_id'];
        $res['result']['total_price'] = $totalCost;
        $res['result']['customer_id'] = $_POST['customer_id'];
        $res['result']['customer_rep'] = $_POST['customer_rep'];
        $this->db->commit();

        $this->placeOrderDetails($id);

        return $res;
    }

    function placeOrderDetails(string $id) {

        $this->db->beginTransaction();

        $query = 'INSERT INTO order_details (order_nr, model, quantity) VALUES (:order_nr, :model, :quantity)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_nr', $id);
        $stmt->bindValue(':model', $_POST['model']);
        $stmt->bindValue(':quantity', $_POST['quantity']);
        $stmt->execute();

        $this->db->commit();
    }

    function cancelOrder(string $order): ?array {

        $rec = $this->verifyOrderID($order);
        if ($rec['code'] != RESTConstants::HTTP_OK) {
            $this->db->rollBack();
            if (isset($rec['detailCode'])) {
                throw new BadRequestException($rec['code'], $rec['detailCode']);
            } else {
                throw new BadRequestException($rec['code']);
            }
        }

        $this->cancelOrderDetails($order);

        $this->db->beginTransaction();
        $res = array();
        $query = 'DELETE FROM orders WHERE order_nr = :order';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order', $order);
        $stmt->execute();

        $res['status'] = RESTConstants::HTTP_OK;
        $res['result'] = "Deleted order with number: " . $order;
        $this->db->commit();
        return $res;
    }

    function cancelOrderDetails(string $order) {
        $this->db->beginTransaction();

        $query = 'DELETE FROM order_details WHERE order_nr = :order';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order', $order);

        $stmt->execute();

        $this->db->commit();
    }

    function totalCost(string $model, string $quantity): string {


        $query = "SELECT ski.msrpp FROM ski WHERE ski.model_id = '" . $model . "'";

        $stmt = $this->db->query($query);

        $modelPrice = $stmt->fetch(PDO::FETCH_ASSOC);

        $res = (int)$modelPrice['msrpp'] * (int)$quantity;


        return (string)$res;
    }

    function verifyOrderID(string $order): array {

        $res = array();

        if (!$this->isOrderExisting($order)) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
            $res['detailCode'] = RESTConstants::DB_FK_CUSTOMER;
            return $res;
        }

        $res['code'] = RESTConstants::HTTP_OK;
        return $res;

    }

    function verifyPayload(array $payload, bool $ignoreId = false): array {

        $res = array();

        if (!$ignoreId && !array_key_exists('order_nr', $payload)) {
            $res['code'] = RESTConstants::DB_ERR_ATTRIBUTE_MISSING;
            return $res;
        }

        if (!array_key_exists('state_id', $payload) && !array_key_exists('parent_id', $payload)
            && !array_key_exists('customer_id', $payload) && !array_key_exists('customer_rep', $payload)
            && !array_key_exists('model', $payload) && !array_key_exists('quantity', $payload)) {
            $res['code'] = RESTConstants::DB_ERR_ATTRIBUTE_MISSING;
            return $res;
        }

        if (isset($payload['state_id'])) {
            if (!$this->isStateExisting($payload['state_id'])) {
                $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
                $res['detailCode'] = RESTConstants::DB_FK_CUSTOMER;
                return $res;
            }
        }

        if (isset($payload['parent_id'])) {
            if (!$this->isOrderExisting($payload['parent_id'])) {
                $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
                $res['detailCode'] = RESTConstants::DB_FK_CUSTOMER;
                return $res;
            }
        }

        if (!$this->isCustomerExisting($payload['customer_id'])) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
            $res['detailCode'] = RESTConstants::DB_FK_CUSTOMER;
            return $res;
        }

        if (!$this->isCustomerRepExisting($payload['customer_rep'])) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
            $res['detailCode'] = RESTConstants::DB_FK_CUSTOMER;
            return $res;
        }

        if (!$this->isModelExisting($payload['model'])) {
            $res['code'] = RESTConstants::DB_ERR_FK_INTEGRITY;
            $res['detailCode'] = RESTConstants::DB_FK_CUSTOMER;
            return $res;
        }

        $res['code'] = RESTConstants::HTTP_OK;
        return $res;


    }

    function isStateExisting(string $id): bool {

        $query = 'SELECT COUNT(*) FROM order_state WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }

    function isOrderExisting(string $order): bool {

        $query = 'SELECT COUNT(*) FROM orders WHERE order_nr = :order_nr';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_nr', $order);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }

    function isCustomerExisting(string $id): bool {

        $query = 'SELECT COUNT(*) FROM customer WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }

    function isCustomerRepExisting(string $nr): bool {

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

    function isModelExisting(string $model): bool {

        $query = 'SELECT COUNT(*) FROM ski_model WHERE model_id = :model';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':model', $model);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row[0] == 0) {
            return false;
        } else {
            return true;
        }
    }
}