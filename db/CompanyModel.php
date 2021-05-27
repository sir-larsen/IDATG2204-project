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
}