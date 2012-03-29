package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.inventory.model.Inventory")]
   	[Bindable]
	public class Inventory
	{
		public function Inventory()
		{
		}
		
		 public var id:int;
	     public var artifactLvl:int;

    	 public var user:User;
    	 public var artifact:ArtifactInfo;

	}
}