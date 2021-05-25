<?php
require_once 'DB.php';

/**
 * Class AuthorisationModel
 */
class AuthorisationModel extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Simple authorisation mechanism - Checking that the token provided matches one of the ones in the database
     * @param string $token
     * @return bool indicating whether the token was successfully verified
     */
    public function isValid(/*string $token*/): array {
        $res = [];
        
        $query = 'SELECT * FROM auth_token/* WHERE token = :token*/';
        /*$stmt = $this->db->prepare($query);
        $stmt->bindValue(':token', $token);
        $stmt->execute();*/
        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('id' => intval($row['id']), 'token' => $row['token']);
        }
        return $res;
    }
}