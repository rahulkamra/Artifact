<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Savior
 */

include_once("../dao/LoginDAO.php");
include_once("../model/User.php");
include_once("../../profile/model/UserProfile.php");
include_once("../../util/dbconnection/Connection.php");
include_once("../../util/properties/Database.php");

class LoginService {
    //put your code here
    function LoginService(){
        $this->methodTable = array(
            "doLogin" => array(
            "description" => "//put your code here",
            "access" => "remote"
            )
        );
    }

    /**
     *
     * @param <String> $username
     * @return <User>
     */
    public function doLogin($username){
        $logindao = new LoginDAO();
        $user=$logindao->isUsernameAvailable($username);
        if($user){
           //session_start();
           $_SESSION['loggedin_user']=$user;
           //NetDebug::trace('session started for user');
          // NetDebug::trace($user);
        }
        
        return $user;
    }
}
?>