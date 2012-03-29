package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.game.model.Answer")]
   	[Bindable]
	public class Answer
	{
		public function Answer()
		{
		}
		
		public var question:String;
		public var answer:String;
		

	}
}