<?php

/**
 * Class AbstractModel root class for all model classes
 */
abstract class AbstractModel extends DB
{
    public function __construct()
    {
        parent::__construct();        
    }

    /**
     * Returns the collection of resources from the database.
     * @param array $query an optional set of conditions that the retrieved
     *              resources need to meet - e.g., array('make' => 'Ford') would
     *              mean that only resources having make = Ford would be returned.
     * @return array an array of associative arrays of resource attributes. The
     *               array will be empty if there are no resources to be returned.
     * @throws BadRequestException in the case the request from the client is badly formatted or violates application
     *         or database constraints.
     */
    abstract function getCollection(array $query = null): array;
}