package com.artifact.controller
{
	import com.artifact.components.Search;
	import com.artifact.servermodel.ArtifactInfo;
	import com.artifact.servermodel.CurrentSearchParty;
	import com.artifact.servermodel.GameProfile;
	import com.artifact.servermodel.GameProgress;
	import com.artifact.servermodel.Inventory;
	import com.artifact.servermodel.User;
	import com.artifact.servermodel.UserProfile;
	
	import mx.controls.Alert;
	import mx.utils.ObjectUtil;
	
	/**
	 * This class take care of the ui iteraction and it knows when to hit the server side and when to display the cached data
	 * 
	 **/
	public class ArtifactUIController
	{
		public function ArtifactUIController()
		{
		}
		[Bindable]
		public static var loggedInUser:User;
		[Bindable]
		public static var userProfile:UserProfile;
		[Bindable]
		public static var gameProfile:GameProfile;
		[Bindable]
		public static var friends:Array;
		[Bindable]
		public static var currentSearchParties:Array;
		[Bindable]
		public static var friendSearchParties:Array;
		[Bindable]
		public static var myArtifacts:Array;
		
		public static var currentSearch:Search;
		
		public function checkUsername(username:String):void{
			Artifact.artifactServiceController.authenticate(username);
		}
		
		
		public function getAllArtifacts():void{
			Artifact.artifactServiceController.getAllArtifacts();
		}
		
		public function startNewSearchParty(artifact:ArtifactInfo):void{
			Artifact.artifactServiceController.startNewSearchParty(artifact);
		}
		public function getSpyQuestions(gameProgress:GameProgress):void{
			Artifact.artifactServiceController.getSpyQuestions(gameProgress);
		}
		
		public function grantSpyProgress(answers:Array,gameProgress:GameProgress):void{
			Artifact.artifactServiceController.grantSpyProgress(answers,gameProgress);
		}
		
		public function grantScoutProgress(gameProgress:GameProgress):void{
			Artifact.artifactServiceController.grantScoutProgress(gameProgress);
		}
		public function grantBuyProgress(gameProgress:GameProgress):void{
			Artifact.artifactServiceController.grantBuyProgress(gameProgress);
		}
		
		public function grantShareProgress(gameProgress:GameProgress):void{
			Artifact.artifactServiceController.grantShareProgress(gameProgress);
		}
		
		public function addSkill(type:String):void{
			Artifact.artifactServiceController.addSkill(type);
		}
		
		public function sellArtifact(artifactPrice:int,inventoryItem:Inventory):void{
			Artifact.artifactServiceController.sellArtifact(artifactPrice,inventoryItem);
		}
		
		
		
		public function findCommonFriendsById(artifactId:int):int{
			var numberOfFriends:int=0;
			for(var count:int = 0 ; count < friendSearchParties.length ; count++){
				var eachObj:CurrentSearchParty = friendSearchParties[count] as CurrentSearchParty;
				if(eachObj.artifact.id == artifactId){
					numberOfFriends++;
				}
			}
			return numberOfFriends;
		}
		
		public function giveCommonFriendsProfileByArtifactId(artifactId:int):Array{
			var commonFriendsArray:Array=new Array();
			
			for(var count:int = 0 ; count < friendSearchParties.length ; count++){
				var eachObj:CurrentSearchParty = friendSearchParties[count] as CurrentSearchParty;
				if(eachObj.artifact.id == artifactId){
					commonFriendsArray.push(getFriendProfileById(eachObj.user.id));
				}
			}
			
			return commonFriendsArray;
		}
		
		public function getFriendProfileById(userId:int):UserProfile{
			for(var count:int = 0 ; count < friends.length ; count++){
				var eachObj:UserProfile=friends[count] as UserProfile;
				if(eachObj.user.id == userId){
					break;
				}
			}
			return eachObj;
		}
		
		
		public function updateCurrentSearchParty(updatedCurrentSearchParty:CurrentSearchParty):void{
			for(var count:int = 0 ; count<currentSearchParties.length ; count++){
				var eachItem:CurrentSearchParty=currentSearchParties[count]  as CurrentSearchParty;
				if(eachItem.id == updatedCurrentSearchParty.id){
					currentSearchParties[count] = updatedCurrentSearchParty;
				}
			}
		}
		
		public function removeItemFromInventoryUI(inventory:Inventory):void{
			var newInventory:Array=new Array
			for(var count:int = 0 ; count<myArtifacts.length ; count++){
				var eachItem:Inventory=myArtifacts[count] as Inventory;
				if(eachItem.id == inventory.id){
				}else{
					newInventory.push(myArtifacts[count]);					
				}	
			}
			myArtifacts=newInventory;
		}
		
		
	}
}