<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompleteProfileWrapper
 *
 * @author kaal
 */
class CompleteProfileWrapper {
    //put your code here
    public $_explicitType = "com.artifact.profile.model.CompleteProfileWrapper";
    public $friendsArray;         //Array of type user profile;
    public $userProfile;         //object of userprofile   have to make it public other wise serialization was not happening a set back to encapsulation
    public $gameProfile;         //object of gameprofile
    public $currentSearchPartiesArray;           //array of current search parties
    public $friendSearchPartiesArray;            //array of current search parties
    public $myArtifacts;                         //array of artifactinfo


    public function getUserProfile(){
        return $this->userProfile;
    }
    public function setUserProfile(UserProfile $userProfile){
        $this->userProfile=$userProfile;
    }
    public function getGameProfile(){
        return $this->gameProfile;
    }
    public function setGameProfile(GameProfile $gameProfile){
        $this->gameProfile=$gameProfile;
    }
}
?>
