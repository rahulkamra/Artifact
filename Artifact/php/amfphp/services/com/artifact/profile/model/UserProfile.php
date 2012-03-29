<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserProfile
 *
 * @author kaal
 */
class UserProfile {
    //put your code here
    public $_explicitType="com.artifact.profile.model.UserProfile";
    public $id;
    public $age;
    public $politicalview;
    public $religion;
    public $language;
    public $humour;
    public $country;
    public $school;
    public $job;
    public $favgame;
    public $imgurl;


    public $user;

    public function getUser(){
        return $this->user;
    }

    public function setUser(User $user){
        $this->user=$user;
    }
}
?>