package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.game.model.GameProgress")]
    [Bindable]
	public class GameProgress
	{
		public function GameProgress()
		{
		}
		
	     public var id:int;
   		 public var friend:UserProfile;
    	 public var csp:CurrentSearchParty;
    	 public var progressType:ProgressType;

   

	}
}