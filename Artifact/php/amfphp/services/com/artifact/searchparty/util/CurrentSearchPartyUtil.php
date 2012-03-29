<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CurrentSearchPartyUtil
 *
 * @author kaal
 */
class CurrentSearchPartyUtil {
    //put your code here
    /**
     *
     * @param <User> $user
     * @return <Array>
     */
    public function getCurrentSearchParty(User $user){
        $currentSearchPartyDAO=new CurrentSearchPartyDAO;
        $currentSearchParties=$currentSearchPartyDAO->getCurrentSearchParty($user);
        return $currentSearchParties;
    }

    /**
     *
     * @param <User> $user
     * @return <Array>
     */
    public function getFriendSearchParty(User $user){
        $currentSearchPartyDAO=new CurrentSearchPartyDAO;
        $friendSearchParties=$currentSearchPartyDAO->getFriendSearchParty($user);
        return $friendSearchParties;
    }

    /**
     *
     * @param <CurrentSearchParty> $currentSearchParty
     * @return <CurrentSearchParty>
     */
    public function updateCurrentSearchPartyProgress($currentSearchParty){
        $currentSearchPartyDAO=new CurrentSearchPartyDAO;
        $updatedCSP=$currentSearchPartyDAO->updateCurrentSearchPartyProgress($currentSearchParty);
        return $updatedCSP;
    }

}
?>
