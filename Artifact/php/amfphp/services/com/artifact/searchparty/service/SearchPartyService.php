<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchPartyService
 *
 * @author kaal
 */
include_once("../../info/model/ArtifactInfo.php");
include_once("../model/CurrentSearchParty.php");
include_once("../dao/CurrentSearchPartyDAO.php");
include_once("../../util/dbconnection/Connection.php");
include_once("../../util/properties/Database.php");
class SearchPartyService {
    //put your code here

    function SearchPartyService(){
        $this->methodTable = array(
        "startSearchParty" => array(
		"description" => "//{_explicitType:'com.artifact.info.model.ArtifactInfo',id:'1',name:'Divine',desc:'A new desc','isActive:'1'}",
		"arguments" => array(
            "artifactObj" => array("type" => "com.artifact.info.model.ArtifactInfo", "required" => true)
            ),
		"access" => "remote"
        )
        );
    }

    //For using service browser
    //{_explicitType:'com.artifact.info.model.ArtifactInfo',id:'1',name:'Divine',desc:'A new desc','isActive:'1''}
    /**
     *
     * @param <ArtifactInfo> $artifactObj
     * @return <CurrentSearchParty>
     */
    public function startSearchParty($artifactObj){
       settype($artifactObj,"object");
       $user=$_SESSION['loggedin_user'];
       $gameProfile=$_SESSION['game_profile'];
       $currentSearchParty=new CurrentSearchParty();
       $currentSearchParty->artifact=$artifactObj;
       $currentSearchParty->artifactLvl=$gameProfile->globalLvl;
       $currentSearchParty->progress=0;
       $currentSearchParty->setUser($user);
       $currentSearchPartyDAO=new CurrentSearchPartyDAO();
       $currentSearchPartyDAO->addNewSearchParty($currentSearchParty);
       
       return $currentSearchParty;

    }
}
?>
