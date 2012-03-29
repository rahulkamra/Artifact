package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.profile.model.UserProfile")]
    [Bindable]
	public class UserProfile
	{
		public function UserProfile()
		{
		}
		
		
			public var id:int;
		    public var age:int;
		    public var politicalview:String;
		    public var religion:String;
		    public var language:String;
		    public var humour:String;
		    public var country:String;
		    public var school:String;
		    public var job:String;
		    public var favgame:String;
		    public var imgurl:String;
		
		    public var user:User;

	}
}