<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameService
 *
 * @author kaal
 */
include_once("../dao/GameDAO.php");
include_once("../util/GameUtil.php");

include_once("../model/Questioniar.php");
include_once("../model/GameProgressResponse.php");
include_once("../model/ProgressType.php");

include_once("../../searchparty/util/CurrentSearchPartyUtil.php");
include_once("../../searchparty/dao/CurrentSearchPartyDAO.php");
include_once("../../searchparty/model/CurrentSearchParty.php");

include_once("../../info/util/ArtifactUtil.php");
include_once("../../info/dao/ArtifactDAO.php");
include_once("../../info/model/ArtifactInfo.php");

include_once("../../inventory/util/InventoryUtil.php");
include_once("../../inventory/model/Inventory.php");
include_once("../../inventory/dao/InventoryDAO.php");

include_once("../../profile/model/UserProfile.php");
include_once("../../profile/dao/UserProfileDAO.php");

include_once("../../util/properties/ServerConstants.php");
include_once("../../util/dbconnection/Connection.php");
include_once("../../util/properties/Database.php");

class GameService {
    //put your code here

    function GameService(){
        $this->methodTable = array(
            "getSpyQuestions" => array(
            "description" => "//put your code here",
            "access" => "remote"
            ),
            "grantSpyProgress" => array(
                "description" => "No description given.",
                "access" => "remote"
            )

        );

        
    }
    /**
     *
     * @param <GameProgress> $gameProgress
     * @return <Array>
     *
     */
    public function getSpyQuestions($gameProgress){
        $user=$_SESSION['loggedin_user'];

        settype($gameProgress,"object");
        settype($gameProgress->friend,"object");
        settype($gameProgress->csp,"object");
        settype($gameProgress->csp->user,"object");
        settype($gameProgress->csp->artifact,"object");
        settype($gameProgress->progressType,"object");
        settype($gameProgress->friend->user,"object");
        
        $classvar=get_class_vars("UserProfile");
        $class=new ReflectionClass("UserProfile");
        $properties=$class->getProperties();
        //unsetting explicit type , user,imgurl and id
        unset ($properties[0]);
        unset ($properties[1]);
        unset ($properties[11]);
        unset ($properties[12]);

        $gameUtil=new GameUtil();
        $randomIndex=$gameUtil->giveRandomNumbers();

        $gamedao=new GameDAO();
        $dataArray=$gamedao->getSpyQuestion($user, $gameProgress);

        //Cannot spy same person twice
        if($dataArray == null){
            return null;
        }

        $questioniar=array();
        for($count = 0 ;$count < 5 ; $count ++){//randomizing questions
            $question=new Questioniar();
            $tempProperty=$properties[$randomIndex[$count]]->name;
            $question->question=$tempProperty;
            $randomOptions=$gameUtil->giveUniqueRandomOptions();
            $question->optionOne=$dataArray[$randomOptions[0]]->$tempProperty;//accessing random data element and getting its
            $question->optionTwo=$dataArray[$randomOptions[1]]->$tempProperty;
            $question->optionThree=$dataArray[$randomOptions[2]]->$tempProperty;
            array_push($questioniar, $question);
        }
        
        return $questioniar;

    }

    /**
     *
     * @param <Array> $answers
     * @param <GameProgress> $gameProgress
     * @return <GameResponse>
     */
    public function grantSpyProgress($answers,$gameProgress){
         //$answers=array();
         $gameResponse=new GameProgressResponse();
         settype($answers,"array");
         settype($gameProgress,"object");
         settype($gameProgress,"object");
         settype($gameProgress->friend,"object");
         settype($gameProgress->csp,"object");
         settype($gameProgress->csp->user,"object");
         settype($gameProgress->csp->artifact,"object");
         settype($gameProgress->progressType,"object");
         settype($gameProgress->friend->user,"object");
         $currentUserGameProfile=$_SESSION['game_profile'];
         for($count = 0 ; $count < count($answers) ; $count++){
             settype($answers[$count],"object");
         }

         $gameResponse->currentSearchParty=$gameProgress->csp;$artifactUtil=new ArtifactUtil;
         $artifact=$gameProgress->csp->artifact;
         if($artifactUtil->isArtifactActive($artifact) == 0){
                 //artifact is in active
            $gameResponse->isSomebodyGetArtifact=true;
            return $gameResponse;
         }
         
         
         $gameDao=new GameDAO();
         $correntAnswers=$gameDao->checkAnswers($answers, $gameProgress);
         
         //cannot spy two persons at time same time
         if($correntAnswers == -1){
             return null;
         }if($correntAnswers == 0 ){
             //no need of update if corrent answers is zero
             $gameResponse->isSomebodyGetArtifact=false;
         }else{
             
             $progressObtained=($correntAnswers*5)*$currentUserGameProfile->spyLvl;
             $gameProgress->csp->progress +=$progressObtained;
             $currentSearchPartyUtil=new CurrentSearchPartyUtil;
             $updatedSearchParty=$currentSearchPartyUtil->updateCurrentSearchPartyProgress($gameProgress->csp);
              if($updatedSearchParty == null){
                  $gameResponse->isSomebodyGetArtifact=true;
                  return $gameResponse;
              }
         }
         
        $gameResponse->percentObjtained=$progressObtained;
             
        if($gameProgress->csp->progress >= 100 ){

             $gameUtil=new GameUtil;
             $gameUtilRes=$gameUtil->obtainArtifact($gameProgress->csp,$currentUserGameProfile);
             $updatedGameProfile=$gameUtilRes[1];
             $gameResponse->updatedGameProfile=$updatedGameProfile;
             $gameResponse->artifact=$gameUtilRes[0];
             $gameResponse->isActifactObtained=true;
         }
         
         return $gameResponse;

    }

    /**
     *
     * @param <GameProgress> $gameProgress
     * @return <GameResponse>
     */
    public function grantScoutProgress($gameProgress){
         $gameResponse=new GameProgressResponse();
         settype($gameProgress,"object");
         settype($gameProgress,"object");
         settype($gameProgress->friend,"object");
         settype($gameProgress->csp,"object");
         settype($gameProgress->csp->user,"object");
         settype($gameProgress->csp->artifact,"object");
         settype($gameProgress->progressType,"object");
         settype($gameProgress->friend->user,"object");
         
         $currentUserGameProfile=$_SESSION['game_profile'];
         
         $gameResponse->currentSearchParty=$gameProgress->csp;
         $artifactUtil=new ArtifactUtil;
         $artifact=$gameProgress->csp->artifact;
         if($artifactUtil->isArtifactActive($artifact) == 0){
                 //artifact is in active
            $gameResponse->isSomebodyGetArtifact=true;
            return $gameResponse;
         }
         
         $gameDao=new GameDAO;
         $progress= $gameDao->getScoutProgress($gameProgress,$currentUserGameProfile);

         $progress=(int)$progress;
         $gameProgress->csp->progress +=$progress;
         
         if($progress == 0){
             //dont update
         }else{
             //update and it will always happen as progress will b greater than zero
             $currentSearchPartyUtil=new CurrentSearchPartyUtil;
             $updatedSearchParty=$currentSearchPartyUtil->updateCurrentSearchPartyProgress($gameProgress->csp);
             if($updatedSearchParty == null){
                 //some body already get the artifact
                $gameResponse->isSomebodyGetArtifact=true;
                return $gameResponse;
             }else{
                 $gameResponse->isSomebodyGetArtifact=false;
             }

         }

         $gameResponse->percentObjtained=$progress;
         if($gameProgress->csp->progress >= 100 ){

             $gameUtil=new GameUtil;
             $gameUtilRes=$gameUtil->obtainArtifact($gameProgress->csp,$currentUserGameProfile);
             $updatedGameProfile=$gameUtilRes[1];
             $gameResponse->updatedGameProfile=$updatedGameProfile;
             $gameResponse->artifact=$gameUtilRes[0];
             $gameResponse->isActifactObtained=true;
         }
         return $gameResponse;
    }

    /**
     *
     * @param <GameProgress> $gameProgress
     * @return <GameResponse>
     */
    public function grantBuyProgress($gameProgress){
        $gameResponse=new GameProgressResponse();
        settype($gameProgress,"object");
        settype($gameProgress,"object");
        settype($gameProgress->friend,"object");
        settype($gameProgress->csp,"object");
        settype($gameProgress->csp->user,"object");
        settype($gameProgress->csp->artifact,"object");
        settype($gameProgress->progressType,"object");
        settype($gameProgress->friend->user,"object");

        $currentUserGameProfile=$_SESSION['game_profile'];

        $gameResponse->currentSearchParty=$gameProgress->csp;
         
        $artifactUtil=new ArtifactUtil;
        $artifact=$gameProgress->csp->artifact;
        if($artifactUtil->isArtifactActive($artifact) == 0){
                //artifact is inactive
           $gameResponse->isSomebodyGetArtifact=true;
           return $gameResponse;
        }
        $gameUtil=new GameUtil;

        //checking weather the person have sufficient money to buy or not
        if(!$gameUtil->validateBuy($currentUserGameProfile,$gameProgress)){
            return null;
        }

        $gameDao=new GameDAO;
        $progress= $gameDao->getBuyProgress($currentUserGameProfile,$gameProgress);
        $progress=(int)$progress;
        $gameProgress->csp->progress +=$progress;

        if($progress == 0){
            //dont update
        }else{
            //update and it will always happen as progress will b greater than zero
            $currentSearchPartyUtil=new CurrentSearchPartyUtil;
            $updatedSearchParty=$currentSearchPartyUtil->updateCurrentSearchPartyProgress($gameProgress->csp);
            if($updatedSearchParty == null){
                //some body already get the artifact
               $gameResponse->isSomebodyGetArtifact=true;
               return $gameResponse;
            }else{
                $gameResponse->isSomebodyGetArtifact=false;
            }
         }

         $gameResponse->percentObjtained=$progress;
         if($gameProgress->csp->progress >= 100 ){

             $gameUtil=new GameUtil;
             $gameUtilRes=$gameUtil->obtainArtifact($gameProgress->csp,$currentUserGameProfile);
             $updatedGameProfile=$gameUtilRes[1];
             $gameResponse->updatedGameProfile=$updatedGameProfile;
             $gameResponse->artifact=$gameUtilRes[0];
             $gameResponse->isActifactObtained=true;
         }
         return $gameResponse;

    }

    /**
     *
     * @param <GameProgress> $gameProgress
     * @return <GameResponse>
     */
    public function grantShareProgress($gameProgress){
         $gameResponse=new GameProgressResponse();
         settype($gameProgress,"object");
         settype($gameProgress,"object");
         settype($gameProgress->friend,"object");
         settype($gameProgress->csp,"object");
         settype($gameProgress->csp->user,"object");
         settype($gameProgress->csp->artifact,"object");
         settype($gameProgress->progressType,"object");
         settype($gameProgress->friend->user,"object");

         $currentUserGameProfile=$_SESSION['game_profile'];

         $gameResponse->currentSearchParty=$gameProgress->csp;
         $artifactUtil=new ArtifactUtil;
         $artifact=$gameProgress->csp->artifact;
         if($artifactUtil->isArtifactActive($artifact) == 0){
                 //artifact is in active
            $gameResponse->isSomebodyGetArtifact=true;
            return $gameResponse;
         }
         $gameUtil=new GameUtil;

        //checking weather the person have sufficient money to buy or not
        if(!$gameUtil->validShare($currentUserGameProfile,$gameProgress)){
             return null;
         }
        $gameDao=new GameDAO;
        $progress= $gameDao->getShareProgress($currentUserGameProfile,$gameProgress);
        $progress=(int)$progress;
        $gameProgress->csp->progress +=$progress;
        
        if($progress == 0){
            //dont update
        }else{
            //update and it will always happen as progress will b greater than zero
            $currentSearchPartyUtil=new CurrentSearchPartyUtil;
            $updatedSearchParty=$currentSearchPartyUtil->updateCurrentSearchPartyProgress($gameProgress->csp);
            if($updatedSearchParty == null){
                //some body already get the artifact
               $gameResponse->isSomebodyGetArtifact=true;
               return $gameResponse;
            }else{
                $gameResponse->isSomebodyGetArtifact=false;
            }
         }

         $gameResponse->percentObjtained=$progress;
         if($gameProgress->csp->progress >= 100 ){

             $gameUtil=new GameUtil;
             $gameUtilRes=$gameUtil->obtainArtifact($gameProgress->csp,$currentUserGameProfile);
             $updatedGameProfile=$gameUtilRes[1];
             $gameResponse->updatedGameProfile=$updatedGameProfile;
             $gameResponse->artifact=$gameUtilRes[0];
             $gameResponse->isActifactObtained=true;
         }
         return $gameResponse;
    }
}
?>