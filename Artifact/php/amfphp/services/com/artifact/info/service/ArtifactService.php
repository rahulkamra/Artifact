<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArtifactService
 *
 * @author kaal
 */
include_once("../../util/dbconnection/Connection.php");
include_once("../../util/properties/Database.php");
include_once("../dao/ArtifactDAO.php");
include_once("../model/ArtifactInfo.php");
class ArtifactService {
    //put your code here

    function ArtifactService(){
        $this->methodTable = array(
            "getActiveArtifacts" => array(
            "description" => "Get Artifacts",
            "access" => "remote"
            )
        );
    }

    /**
     *
     * @return <Array>
     */
    public function getActiveArtifacts(){
        $user=$_SESSION['loggedin_user'];
        $artifactDAO=new ArtifactDAO();
        $artifactList=$artifactDAO->getArtifacts($user);
        return $artifactList;
    }

    /**
     *
     * @param <int> $artifactPrice
     * @param <inventory> $inventoryItem
     * @return <GameProfile>
     */
    public function sellArtifact($artifactPrice,$inventoryItem){
        //add gold to the gameprofile
        //remove item from inventory
        settype($inventoryItem,"object");
        settype($inventoryItem->user,"object");
        settype($inventoryItem->artifact,"object");

        $currentUserGameProfile=$_SESSION['game_profile'];
        $currentUserGameProfile->gold=$currentUserGameProfile->gold+$artifactPrice;
        
        $artifactDAO=new ArtifactDAO();
        $artifactDAO->sellArtifact($inventoryItem, $artifactPrice, $currentUserGameProfile);
        return $currentUserGameProfile;
    }
}
?>