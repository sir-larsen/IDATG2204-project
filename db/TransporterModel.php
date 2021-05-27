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

    //UPDATE `shipment` SET `state_id` = '2' WHERE `shipment`.`nr` = 1;
    function updateShipment(?array $resource, string $id): array
    {

        $this->db->beginTransaction();
        $rec = $this->verifyNr($resource, true);

        if($rec['code'] != RESTConstants::HTTP_OK){
            $this->db->rollBack();
            if (isset($rec['detailCode'])) {
                throw new BadRequestException($rec['code'], $rec['detailCode']);
            }else {
                throw new BadRequestException($rec['code']);
            }
        }

        $num = intval($id);
        $res = array();
        $query = "UPDATE shipment SET state_id = 2 WHERE shipment.nr = '".$num."'";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $this->db->commit();

        $res['code'] = RESTConstants::HTTP_OK;

        $shipment = $this->getShipments();

        foreach ($shipment as $key => $value) {

            if ($value['nr'] == $id) {
                print("shipment nr: " . $id . " is set ready for shipping:" . "\n\n");
                return $shipment;
            }else{
                print("shipment nr: " . $id . " is not registered in database:" . "\n\n");
                throw new BadRequestException($rec['code']);
            }
        }
    }



    function verifyNr(?array $resource, bool $ignoreId = false): array
    {
        $res = array();

        if (!$ignoreId && !array_key_exists('nr', $resource)) {
            $res['code'] = RESTConstants::DB_ERR_ATTRIBUTE_MISSING;
            return $res;
        }

        $res['code'] = RESTConstants::HTTP_OK;

        return $res;
    }



    function getShipments(?array $query = null): array
    {

        $res = [];

        //Query to get all ski-models and exchanging attribute Id's for their actual names
        $query = 'SELECT nr, pickup_date, company_name, driver_id, state_id,
       address_id
        FROM shipment';

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('nr' => intval($row['nr']), 'pickup_date' => $row['pickup_date'], 'company_name' => $row['company_name'],
                'driver_id' => $row['driver_id'], 'state_id' => $row['state_id'], 'address_id' => $row['address_id'],);
        }

        return $res;
    }

}





