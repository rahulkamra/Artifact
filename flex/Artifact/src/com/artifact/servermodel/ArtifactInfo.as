package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.info.model.ArtifactInfo")]
    [Bindable]
	public class ArtifactInfo
	{
		public function ArtifactInfo()
		{
		}
		
	 public var id:int;
   	 public var name:String;
     public var desc:String;
     public var isActive:Boolean;

	}
}