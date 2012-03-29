<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameProfile
 *
 * @author kaal
 */
class GameProfile {
    //put your code here
    public $_explicitType="com.artifact.game.model.GameProfile";
    public $id;
    public $gold;
    public $exp;
    public $globalLvl;
    public $spyLvl;
    public $scoutLvl;
    public $shareLvl;
    public $buyLvl;

    public $user;

     public function getUser(){
        return $this->user;
    }

    public function setUser(User $user){
        $this->user=$user;
    }
}
?>
