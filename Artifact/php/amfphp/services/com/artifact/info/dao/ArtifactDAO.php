<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArtifactDAO
 *
 * @author kaal
 */
class ArtifactDAO {
    //put your code here

    //
    /**
     *
     * @param <User> $user
     * @return <Array>
     * @SQL SELECT * FROM artifactinfo where id not in (select id from currentsearchparty where userid = 2)
     */
    public function getArtifacts(User $user){
        $con = Connection::createConnection();
        $result = mysql_query("SELECT * FROM artifactinfo where id not in (select artifactid from currentsearchparty where userid = $user->id) AND isactive = 1");
        $artifactList=array();
        while($row = mysql_fetch_array($result)){
            if($row['isactive'] == 1){
                $artifact=new ArtifactInfo();
                $artifact->id=$row['id'];
                $artifact->name=$row['name'];
                $artifact->desc=$row['desc'];
                $artifact->isActive=1;
                array_push($artifactList, $artifact);
            }
        }
        Connection::closeConnection($con);
        return $artifactList;
    }

    /**
     *
     * @param <ArtifactInfo> $artifact
     * @return <null>
     * @SQL update artifactinfo set isactive = 0 where id = 1
     */
    public function makeArtifactInactive($artifact){
        $con = Connection::createConnection();
        $acrifactInactive=mysql_query("update artifactinfo set isactive = 0 where id = $artifact->id");
        mysql_query("commit");
        Connection::closeConnection($con);
        return;
    }

    /**
     *
     * @param <Artifact> $artifact
     * @return <Boolean>
     * @SQL Select isactive from artifactinfo where id = 1
     */
    public function isArtifactActive($artifact){
        $con = Connection::createConnection();
        $artifact=mysql_query("Select isactive from artifactinfo where id = $artifact->id");
        while($row = mysql_fetch_array($artifact)){
            $isActive=$row['isactive'];
        }
        Connection::closeConnection($con);
        return $isActive;

    }

    /**
     *
     * @param <Inventory> $inventory
     * @param <int> $artifactPrice
     * @param <GameProfile> $updatedGameProfile
     * @return <Boolean>
     * @SQL update gameprofile set gold = 100 where userid = 1
     * @SQL delete from inventory where id=1 AND userid=1
     *
     */
    public function sellArtifact($inventory,$artifactPrice,$updatedGameProfile){
        $con = Connection::createConnection();
        $user=$updatedGameProfile->user;
        $updateGameProfile=mysql_query("update gameprofile set gold = $updatedGameProfile->gold where userid = $user->id");
        //delete from inventory
        $deleteInventory=mysql_query("delete from inventory where id=$inventory->id AND userid=$user->id");
        mysql_query("commit");
        Connection::closeConnection($con);
        return true;

    }

        
}
?>
