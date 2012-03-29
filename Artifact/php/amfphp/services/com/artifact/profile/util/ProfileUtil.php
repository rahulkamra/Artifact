<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileUtil
 *
 * @author admin
 */
class ProfileUtil {
    //put your code here

    /**
     *
     * @param <GameProfile> $userProfile
     * @param <int> $expPoints
     * @return <GameProfile>
     */
    public function giveExperience($userProfile,$expPoints){
        $userProfileDAO=new UserProfileDAO;
        $updatedProfile=$userProfileDAO->giveExperience($currentSearchParty,$expPoints);
        return $updatedProfile;

    }
}
?>
