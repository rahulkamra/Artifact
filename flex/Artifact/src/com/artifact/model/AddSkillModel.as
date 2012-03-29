package com.artifact.model
{
	public class AddSkillModel
	{
		public function AddSkillModel()
		{
		}
		//Not using delete at the end
		[Bindable]
		public var currentLevel:int;
		[Bindable] 
		public var experiencePointsAvailable:int;
		[Bindable]
		public var spyLevel:int;
		[Bindable]
		public var buyLevel:int;
		[Bindable]
		public var scoutLevel:int;
		[Bindable]
		public var shareLevel:int;
		

	}
}