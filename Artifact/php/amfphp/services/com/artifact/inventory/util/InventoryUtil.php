<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventoryUtil
 *
 * @author admin
 */
class InventoryUtil {
    //put your code here

    /**
     *
     * @param <User> $user
     * @return <Array>
     */
    public function getInventory(User $user){
        $inventoryDao=new InventoryDAO();
        $inventoryList=$inventoryDao->getInventory($user);
        return $inventoryList;
    }

    /**
     *
     * @param <Inventory> $inventory
     * @return <Inventory>
     */
    public function addToInventory($inventory){
        $inventoryDao=new InventoryDAO();
        $inventoryRet=$inventoryDao->addToInventory($inventory);
        return $inventoryRet;
    }
}
?>
