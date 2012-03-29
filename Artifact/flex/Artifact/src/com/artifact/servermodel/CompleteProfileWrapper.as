package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.profile.model.CompleteProfileWrapper")]
    [Bindable]
	public class CompleteProfileWrapper
	{
		public function CompleteProfileWrapper()
		{
		}
		public var friendsArray:Array;         
    	public var userProfile:UserProfile;         //object of userprofile   
    	public var gameProfile:GameProfile;         //object of gameprofile
    	public var currentSearchPartiesArray:Array;           //array of current search parties
    	public var friendSearchPartiesArray:Array;            //array of current search parties
    	public var myArtifacts:Array;    

	}
}