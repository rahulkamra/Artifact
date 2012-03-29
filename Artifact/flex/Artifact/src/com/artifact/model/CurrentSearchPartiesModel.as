package com.artifact.model
{
	public class CurrentSearchPartiesModel
	{
		public function CurrentSearchPartiesModel()
		{
		}
		[Bindable]
		public var cspId:int;
		[Bindable]
		public var artifactName:String ;
		[Bindable]
		public var artifactLvl:int;
		[Bindable]
		public var partyProgress:int;
	}
}