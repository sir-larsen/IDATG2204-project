<?php
require_once 'DB.php';
require_once 'DBConstants.php';

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
     * @param string $userType - Type of user to be checked for, see in DBConstants.php
     * @return bool indicating whether the token was successfully verified
     */
    public function isValid(string $token, string $userType): bool {
        $res = []; //Array for storing db response
        
        $query = 'SELECT * FROM auth_token/* WHERE token = :token*/';
        /*$stmt = $this->db->prepare($query);
        $stmt->bindValue(':token', $token);
        $stmt->execute();*/
        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = array('id' => intval($row['id']), 'token' => $row['token']);
        }
        //return $res; //FJERN DENNE ETTERPÅ

        switch ($userType) { //Checking for the different usertypes here
            case DBConstants::EMPLOYEE_CREP:
                if ($res[0]['token'] == $token) {
                    return true;
                } else {
                    return false;
                }
            case DBConstants::EMPLOYEE_SKEEPER:
                if ($res[1]['token'] == $token) {
                    return true;
                } else {
                    return false;
                }
            case DBConstants::EMPLOYEE_PPLANNER:
                if ($res[2]['token'] == $token) {
                    return true;
                } else {
                    return false;
                }
            case DBConstants::CUSTOMER:
                if ($res[3]['token'] == $token) {
                    return true;
                } else {
                    return false;
                }
            case DBConstants::TRANSPORT:
                if ($res[4]['token'] == $token) {
                    return true;
                } else {
                    return false;
                }
            default:
                //throw new BadRequestException("bad request " . 400);
                return false;
        }
    }
}