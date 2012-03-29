<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FriendsUtil
 *
 * @author admin
 */
class FriendsUtil {
    //put your code here

    /**
     *
     * @param <User> $user
     * @return <Array>
     */
    public function getFriends(User $user){
        $friendDAO=new FriendsDAO();
        return $friendDAO->getAllFriends($user);
    }
}
?>
