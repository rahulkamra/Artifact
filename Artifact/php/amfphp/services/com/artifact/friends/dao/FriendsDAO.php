<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FriendsDAO
 *
 * @author admin
 */
class FriendsDAO {
    //put your code here
    /*
     *
     * @SQL =SELECT u1.id as "user_id", u1.username as "user_name", u2.* FROM user u1, userprofile u2 where u1.id = u2.id AND u1.id != 1
     * For this function i am just returning all the rows of user except the current logged in user
     *
     */
    public function getAllFriends(User $user){
        $con = Connection::createConnection();
        $result = mysql_query("SELECT u1.id as user_id, u1.username as user_name, u2.* FROM user u1, userprofile u2 where u1.id = u2.id AND u1.id != $user->id");
        $friendList=array();
        while($row = mysql_fetch_array($result)){

            $userProfile=new UserProfile();
            $tempUser=new User();

            //setting user
            $tempUser->id=$row['user_id'];
            $tempUser->username=$row['user_name'];
            $userProfile->setUser($tempUser);

            //Setting user profile
            $userProfile->id=$row['id'];
            $userProfile->age=$row['age'];
            $userProfile->country=$row['country'];
            $userProfile->favgame=$row['favgame'];
            $userProfile->humour=$row['humour'];
            $userProfile->imgurl=$row['imgurl'];
            $userProfile->job=$row['job'];
            $userProfile->language=$row['language'];
            $userProfile->politicalview=$row['politicalview'];
            $userProfile->religion=$row['religion'];
            $userProfile->school=$row['school'];
            array_push($friendList, $userProfile);
        }
        return $friendList;
    }
}
?>
