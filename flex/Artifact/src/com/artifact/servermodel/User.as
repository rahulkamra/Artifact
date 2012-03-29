package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.login.model.User")]
    [Bindable]
	public class User
	{
		
		public var id:int;
		public var username:String;

	}
}