<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameUtil
 *
 * @author admin
 */
class GameUtil {
    //put your code here

    /**
     *
     * @param <User> $user
     * @return <GameProfile>
     */
    public function getGameProfile(User $user){
        $gameDAO=new GameDAO();
        return $gameDAO->getGameProfile($user);
    }

    /**
     *
     * @return <int>
     */
    public function giveRandomNumbers(){
        $questionIndex= array();
        for($count = 0 ;$count < 5 ; $count ++){
            while(true){
                $index=rand(2, 10);
                if(in_array($index, $questionIndex)){
                    continue;
                }else{
                    array_push($questionIndex, $index);
                    break;
                }
            }
        }
        return $questionIndex;
    }

    /**
     *
     * @return <int>
     */
    public function giveUniqueRandomOptions(){
            $optionIndex= array();
            for($count = 0 ;$count < 3 ; $count ++){
                while(true){
                    $index=rand(0,2);
                    if(in_array($index, $optionIndex)){
                        continue;
                    }else{
                        array_push($optionIndex, $index);
                        break;
                    }
                }
            }
            return $optionIndex;
    }

    /**
     *
     * @param <CurrentSearchParty> $currentSearchParty
     * @param <GameProfile> $gameProfile
     * @return <Array>
     */
    public function obtainArtifact($currentSearchParty,$gameProfile){

             //add to inventory
             //give experience i.e update game profile
             //chk for lvl up
             //make item inactive

             /*
              * Adding to inventory
              */
             $inventoryUtil=new InventoryUtil();
             $inventory=new Inventory();
             
             $inventory->artifact=$currentSearchParty->artifact;
             $inventory->artifactLvl=$currentSearchParty->artifactLvl;
             $inventory->user=$currentSearchParty->user;
             $inventory=$inventoryUtil->addToInventory($inventory);

             /*
              * Calulate exp
              */
              $exp=$currentSearchParty->artifactLvl*100;
              $exp=$gameProfile->exp+$exp;

              /*
               * Update game profile and checking for levelup and updateing level
               */

               $userProfileDAO=new UserProfileDAO;
               $updatedProfile=$userProfileDAO->giveExperience($gameProfile,$exp);//exp is the updated exp
                /*
                 * Making the artifact inactive
                 */
        
               $artifactUtil=new ArtifactUtil();
               $artifactUtil->makeArtifactInactive($currentSearchParty->artifact);

               $returnArray=array();
               array_push($returnArray, $inventory);//on position 0 inventory will b thr
               array_push($returnArray, $updatedProfile);//on 1st position updated profile
               
               return $returnArray;
    }


    /**
     *
     * @param <GameProfile> $currentUserGameProfile
     * @param <GameProgress> $gameProgress
     * @return <Boolean>
     */
     public function validateBuy($currentUserGameProfile,$gameProgress){
        $price_of_info=$gameProgress->csp->artifactLvl*rand(0, 1000);
        if($currentUserGameProfile->gold >= $price_of_info){
            return true;
        }else{
            return false;
        }
    }

    /**
     *
     * @param <GameProfile> $currentUserGameProfile
     * @param <GameProgress> $gameProgress
     * @return <Boolean>
     */
    public function validShare($currentUserGameProfile,$gameProgress){
        $currentProgress=$gameProgress->csp->progress;
        if($currentProgress >= 10 ){
            return true;
        }else{
            return false;
        }
        
    }

}
?>
