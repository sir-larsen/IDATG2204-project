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

        //Query to get all ski-models and exchanging attribute Id's for their actual names
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
            $res[] = array('product_no' => intval($row['product_no']), 'url' => $row['url'], 'msrpp' => $row['msrpp'],
                            'in_production' => $row['in_production'],'model' => $row['model'], 'grip' => $row['grip'],
                        'type' => $row['type'], 'min_weight' => $row['min_weight'], 'max_weight' => $row['max_weight'],
                        'size' => $row['size'], 'temp' => $row['temp'],);
        }

        //Changes the status code for in production to either yes or no.
        foreach ($res as $key => $value){

            if ($value['in_production'] == 0){
                $res[$key]['in_production'] = 'yes';
            }else{
                $res[$key]['in_production'] = 'no';
            }

        }

        return $res;
    }


    /**
     * Returns the collection of resources from the database.
     * @param array $query an optional set of conditions that the retrieved
     *              resources need to meet - e.g., array('counties' => array('...', ...)) would
     *              mean that only resources having make = Ford would be returned.
     *  @param model The specified model of the ski the user wants to filter on.
     *
     * @return array an array of associative arrays of resource attributes. The
     *               array will be empty if there are no resources to be returned.
     * @throws BadRequestException in the case the request from the client is badly formatted or violates application
     *         or database constraints.
     * @throws BadRequestException
     */

    function getModel(?array $query = null, string $model): array
    {
        $res = [];
        $fixed = str_replace("-", " ", $model);
        //Query to get all ski-models and exchanging attribute Id's for their actual names
        $query = "SELECT ski.product_no, ski.url, ski.msrpp, ski.historical AS in_production, ski_model.name AS model,
       grip_system.name AS grip, ski_type.name AS type, weight_class.min_weight AS min_weight,
       weight_class.max_weight AS max_weight, ski.size, ski.temp
       FROM ski
       INNER JOIN ski_model ON ski.model_id = ski_model.model_id
       INNER JOIN grip_system ON ski.grip_id = grip_system.grip_id
       INNER JOIN ski_type ON ski.type_id = ski_type.type_id
       INNER JOIN weight_class ON ski.weight_id = weight_class.id WHERE ski_model.name = '".$fixed."'";

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('product_no' => intval($row['product_no']), 'url' => $row['url'], 'msrpp' => $row['msrpp'],
                'in_production' => $row['in_production'],'model' => $row['model'], 'grip' => $row['grip'],
                'type' => $row['type'], 'min_weight' => $row['min_weight'], 'max_weight' => $row['max_weight'],
                'size' => $row['size'], 'temp' => $row['temp'],);
        }

        //Changes the status code for in production to either yes or no.

        foreach ($res as $key => $value){

                if ($value['in_production'] == 0){
                    $res[$key]['in_production'] = 'yes';
                }else{
                    $res[$key]['in_production'] = 'no';
                }

            }
        return $res;
    }

    /**
     * Returns the collection of resources from the database.
     * @param array $query an optional set of conditions that the retrieved
     *              resources need to meet - e.g., array('counties' => array('...', ...)) would
     *              mean that only resources having make = Ford would be returned.
     *  @param grip The specified name of the gripsystem the user wants to filter on.
     *
     * @return array an array of associative arrays of resource attributes. The
     *               array will be empty if there are no resources to be returned.
     * @throws BadRequestException in the case the request from the client is badly formatted or violates application
     *         or database constraints.
     * @throws BadRequestException
     */

    function getGrip(?array $query = null, string $grip): array
    {
        $res = [];
        $fixed = str_replace("-", " ", $grip);
        //Query to get all ski-models and exchanging attribute Id's for their actual names
        $query = "SELECT ski.product_no, ski.url, ski.msrpp, ski.historical AS in_production, ski_model.name AS model,
       grip_system.name AS grip, ski_type.name AS type, weight_class.min_weight AS min_weight,
       weight_class.max_weight AS max_weight, ski.size, ski.temp
       FROM ski
       INNER JOIN ski_model ON ski.model_id = ski_model.model_id
       INNER JOIN grip_system ON ski.grip_id = grip_system.grip_id
       INNER JOIN ski_type ON ski.type_id = ski_type.type_id
       INNER JOIN weight_class ON ski.weight_id = weight_class.id WHERE grip_system.name = '".$fixed."'";

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('product_no' => intval($row['product_no']), 'url' => $row['url'], 'msrpp' => $row['msrpp'],
                'in_production' => $row['in_production'],'model' => $row['model'], 'grip' => $row['grip'],
                'type' => $row['type'], 'min_weight' => $row['min_weight'], 'max_weight' => $row['max_weight'],
                'size' => $row['size'], 'temp' => $row['temp'],);
        }

        //Changes the status code for in production to either yes or no.

        foreach ($res as $key => $value){

            if ($value['in_production'] == 0){
                $res[$key]['in_production'] = 'yes';
            }else{
                $res[$key]['in_production'] = 'no';
            }

        }
        return $res;
    }

}


