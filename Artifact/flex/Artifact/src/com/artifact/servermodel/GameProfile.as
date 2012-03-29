package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.game.model.GameProfile")]
    [Bindable]
	public class GameProfile
	{
		public function GameProfile()
		{
		}
		
	  public var id:int;
  	  public var gold:int;
      public var exp:int;
      public var globalLvl:int;
      public var spyLvl:int;
      public var scoutLvl:int;
      public var shareLvl:int;
      public var buyLvl:int;

      public  var user:User;
      
      public function get experiencePointsAvailable():int{
      	return globalLvl-spyLvl-scoutLvl-shareLvl-buyLvl;
      }

	}
}