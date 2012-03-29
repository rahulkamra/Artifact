package com.artifact.servermodel
{
	[RemoteClass(alias="com.artifact.game.model.Questioniar")]
    [Bindable]
	public class Questioniar
	{
		public function Questioniar()
		{
		}
		
		public var question:String;
		public var optionOne:String;
		public var optionTwo:String;
		public var optionThree:String;

	}
}