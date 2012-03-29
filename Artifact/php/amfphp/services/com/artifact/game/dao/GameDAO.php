<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameDAO
 *
 * @author admin
 */
class GameDAO {
    //put your code here
    /**
     *
     * @param <User> $user
     * @return <GameProfile>
     * 
     */
    public function getGameProfile(User $user){
        $con = Connection::createConnection();
        $result = mysql_query("Select * From gameprofile Where userid=$user->id");
        $tempArray=mysql_fetch_array($result);
        if(mysql_num_rows($result) == 1){
            $gameProfile=new GameProfile;
            $gameProfile->id=$tempArray['id'];
            $gameProfile->user=$user;
            $gameProfile->buyLvl=$tempArray['buylvl'];
            $gameProfile->exp=$tempArray['exp'];
            $gameProfile->globalLvl=$tempArray['globallvl'];
            $gameProfile->gold=$tempArray['gold'];
            $gameProfile->scoutLvl=$tempArray['scoutlvl'];
            $gameProfile->shareLvl=$tempArray['sharelvl'];
            $gameProfile->spyLvl=$tempArray['spylvl'];
        }
        Connection::closeConnection($con);
        return $gameProfile;
    }

    //select * from userprofile where userprofile.userid !=2 order by rand() limit 2
    //select * from gameprogress where cspid=1 AND friendid =1 AND progresstypeid=(select id from progresstype where progresstype ="SPY")
    public function getSpyQuestion($user,$gameProgress){
        $con = Connection::createConnection();
        //first we need to check weather that person has spied him already or not
        $spy=ServerConstants::SPY;
        if($this->canSpy($gameProgress)){
            $friendUser=$gameProgress->friend->user;
            $result=mysql_query("select * from userprofile where userprofile.userid !=$friendUser->id order by rand() limit 2");
            $dataArray=array();
            while($row = mysql_fetch_array($result)){
                $userprofile=new UserProfile;
                $userprofile->id=$row['id'];
                $userprofile->setUser($user);
                $userprofile->age=$row['age'];
                $userprofile->country=$row['country'];
                $userprofile->favgame=$row['favgame'];
                $userprofile->humour=$row['humour'];
                $userprofile->imgurl=$row['imgurl'];
                $userprofile->job=$row['job'];
                $userprofile->language=$row['language'];
                $userprofile->politicalview=$row['politicalview'];
                $userprofile->religion=$row['religion'];
                $userprofile->school=$row['school'];
                array_push($dataArray, $userprofile);
            }
            /* Getting data of friend whom we want to spy i.e. the right options */
            $friendProfile=$gameProgress->friend;
            array_push($dataArray, $friendProfile);
            Connection::closeConnection($con);
            return $dataArray;
        }else{
            Connection::closeConnection($con);
            return null;
        }
    }

    public function canSpy($gameProgress){
        $spy=ServerConstants::SPY;
        $csp=$gameProgress->csp;
        $friend=$gameProgress->friend;
        $friendUser=$friend->user;
        $chkResult = mysql_query("select * from gameprogress where cspid=$csp->id AND friendid =$friendUser->id AND progresstypeid=(select id from progresstype where progresstype ='$spy')");
        if(mysql_num_rows($chkResult) == 1){
            //cannot spy
            return false;
        }else{
            //can spy
            return true;
        }
        
    }
    public function checkAnswers($answers,$gameProgress){
        $correctAnswers=0;
        $con = Connection::createConnection();
        if($this->canSpy($gameProgress)){
            for($count = 0 ; $count < count($answers) ; $count++){
                $eachAnswer=$answers[$count];
                if($eachAnswer->answer == null){
                    continue;
                }
                $friend=$gameProgress->friend;
                $friendUser=$friend->user;

                $chkResult = mysql_query("select * from userprofile where userid = $friendUser->id AND $eachAnswer->question =  '$eachAnswer->answer' ");
                
                if($chkResult == false){
                     return mysql_error();
                }
                 if(mysql_num_rows($chkResult) == 1){
                     $correctAnswers++;
                 }
            }
            //save it in game progress so that person will not b able to spy again
            $progressType=$this->giveProgressTypeObj(ServerConstants::SPY);             
            $gameProgress->progressType=$progressType;
            $this->addGameProgress($gameProgress);
            Connection::closeConnection($con);
            return $correctAnswers;
        }else{
            return -1;
        }
    }

    public function giveProgressTypeObj($progressType){
        $progress=mysql_query("select * from progresstype where progresstype = '$progressType' ");
             while($row = mysql_fetch_array($progress)){
                 $progressType=new ProgressType();
                 $progressType->id=$row['id'];
                 $progressType->progressType=$row['progresstype'];
        }
        return $progressType;
    }
    /*
     * Expects a complete game progress object with progressType as another object of ProgressType class
     *
     */
    public function addGameProgress($gameProgress){
        $progressType=$gameProgress->progressType;
        $csp=$gameProgress->csp;
        $friend=$gameProgress->friend;
        $friendUser=$friend->user;
        
        $result = mysql_query("Insert into gameprogress values (NULL,$csp->id,$friendUser->id,$progressType->id)");
        $gameProgress->id=mysql_insert_id();
        return $gameProgress;
    }

    //SELECT count(*) as count FROM gameprogress,progresstype where gameprogress.progresstypeid = progresstype.id AND progresstype.progresstype = "Spy";;
    public function getScoutProgress($gameProgress,$gameProfile){
        $con = Connection::createConnection();
        $scout=ServerConstants::SCOUT;
        $csp=$gameProgress->csp;
        $count=mysql_query("SELECT count(*) as count FROM gameprogress,progresstype where gameprogress.progresstypeid = progresstype.id AND progresstype.progresstype = '$scout' AND gameprogress.cspid = $csp->id");
        while($row = mysql_fetch_array($count)){
            $rowcount=$row['count'];
        }
        $base=0.5;
        $rowcount=$rowcount+1;
        $progress=pow($base, $rowcount)*$gameProfile->scoutLvl*5;
        $progressType=$this->giveProgressTypeObj(ServerConstants::SCOUT);
        $insert=mysql_query("insert into gameprogress values (NULL,$csp->id,NULL,$progressType->id)");
        mysql_query("commit");
        Connection::closeConnection($con);
        return $progress;
    }

    public function getBuyProgress($gameProfile,$gameProgress){
        $con = Connection::createConnection();
        $buy=ServerConstants::BUY;
        $csp=$gameProgress->csp;
        $friendUser= $gameProgress->friend->user;
        $count=mysql_query("SELECT count(*) as count FROM gameprogress,progresstype where gameprogress.progresstypeid = progresstype.id AND progresstype.progresstype = '$buy' AND gameprogress.cspid = $csp->id AND gameprogress.friendid = $friendUser->id");
        while($row = mysql_fetch_array($count)){
            $rowcount=$row['count'];
        }
        $base=0.5;
        $rowcount=$rowcount+1;
        $progress=pow($base, $rowcount)*$gameProfile->buyLvl*5;
        $progressType=$this->giveProgressTypeObj(ServerConstants::BUY);
        $insert=mysql_query("insert into gameprogress values (NULL,$csp->id,$friendUser->id,$progressType->id)");
        mysql_query("commit");
        Connection::closeConnection($con);
        return $progress;
        
    }

    public function getShareProgress($gameProfile,$gameProgress){
        $con = Connection::createConnection();
        $share=ServerConstants::SHARE;
        $csp=$gameProgress->csp;
        $friendUser= $gameProgress->friend->user;
        $count=mysql_query("SELECT count(*) as count FROM gameprogress,progresstype where gameprogress.progresstypeid = progresstype.id AND progresstype.progresstype = '$share' AND gameprogress.cspid = $csp->id AND gameprogress.friendid = $friendUser->id");
        while($row = mysql_fetch_array($count)){
            $rowcount=$row['count'];
        }
        $base=0.5;
        $rowcount=$rowcount+1;
        $progress=pow($base, $rowcount)*$gameProfile->shareLvl*5;
        $progressType=$this->giveProgressTypeObj(ServerConstants::SHARE);
        $insert=mysql_query("insert into gameprogress values (NULL,$csp->id,$friendUser->id,$progressType->id)");
        mysql_query("commit");
        Connection::closeConnection($con);
        return $progress;
    }

   
}
?>