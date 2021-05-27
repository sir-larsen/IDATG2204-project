<?php
require_once 'DB.php';
require_once 'AbstractModel.php';
require_once 'BadRequestException.php';

//TEST CLASS FOR TABLE
/**
 * Class PublicModel for accessing skis data in the database
 */
class PublicModel extends AbstractModel {
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

        $query = 'SELECT ski.product_no, ski.url, ski.msrpp, ski.historical AS in_production, ski_model.name AS model,
       grip_system.name AS grip, ski_type.name AS type, weight_class.min_weight AS min_weight,
       weight_class.max_weight AS max_weight, ski.size, ski.temp
       FROM ski
       INNER JOIN ski_model ON ski.model_id = ski_model.model_id
       INNER JOIN grip_system ON ski.grip_id = grip_system.grip_id
       INNER JOIN ski_type ON ski.type_id = ski_type.type_id
       INNER JOIN weight_class ON ski.weight_id = weight_class.id';

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('id' => intval($row['id']), 'start_date' => $row['start_date'], 'end_date' => $row['end_date'], 'customer_rep' => $row['customer_rep']);
        }
        return $res;
    }
}