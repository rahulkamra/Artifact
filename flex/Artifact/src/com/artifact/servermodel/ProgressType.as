package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.game.model.ProgressType")]
    [Bindable]
	public class ProgressType
	{
		public function ProgressType()
		{
		}
		
		 public var id:int;
    	 public var progressType:String;

	}
}