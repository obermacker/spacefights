<?php

class loopData {
    public $playerID;
    public $playerName;
	public $planetID;
	public $constructionLoopStructureID;
	public $constructionLoopStructureName;
	public $constructionLoopUntil;
	public $planetResourcesIron;
	public $planetResourcesSilicon;
	public $planetResourcesWater;
	public $planetResourcesEnergy;
	public $playerResourcesKarma;
	public $structureCostIron;
	public $structureCostSilicon;
	public $structureCostWater;
	public $structureCostEnergy;
	public $structureCostKarma;
}


class message {
	public $messageID;
	public $messageSent;
    public $senderID;
    public $senderName;
    public $recipientID;
    public $recipientName;
    public $messageHasBeenRead;
    public $messageSubject;
    public $messageText;
    public $logbookMessage;
    public $chatbotMessage;
}


// datasets

class datasetPlanet {
	const database = 'galaxy1';
    const table = 'planet';
    const constructionLoopStart = 'Bauschleife_Gebaeude_Start';
    const constructionLoopUntil = 'Bauschleife_Gebaeude_Bis';
    const constructionLoopStructureID ='Bauschleife_Gebaeude_ID';
    const constructionLoopStructureName = 'Bauschleife_Gebaeude_Name';
    const planetResourcesIron = 'Ressource_Eisen';
    const planetResourcesSilicon = 'Ressource_Silizium';
    const planetResourcesWater = 'Ressource_Wasser';
    const planetResourcesEnergy = 'Ressource_Energie';
    const playerID = 'Spieler_ID';
    const planetID = 'Planet_ID';
}

class datasetMessages {
	const database = 'galaxy1';
    const table = 'nachrichten';
    const messageID = 'ID';
	const messageSent = 'Zeit';
    const senderID = 'Absender_ID';
    const senderName = 'Absender_Name';
    const recipientID ='Empfaenger_ID';
    const recipientName = 'Empfaenger_Name';
    const messageHasBeenRead = 'Gelesen';
    const messageSubject = 'Betreff';
    const messageText = 'Text';
    const logbookMessage = 'Logbuch';
    const chatbotMessage = 'Chatbot';
}

class datasetPlayer {
	const database = 'galaxy1';
    const table = 'spieler';
    const ID = 'ID';                                    // not used in code yet !?
    const playerID = 'Spieler_ID';
    const playerName = 'Spieler_Name';
    const playerType = 'Typ';                           // not used in code yet !?
    const playerImage = 'avatar';
    const lastChosenPlanet = 'Letzter_Planet';
    const timestampBotProduction = 'Bot_Produktion_Zeit';
    const techLevelType = ['notSet','Tech_1','Tech_2','Tech_3','Tech_4','Tech_5','Tech_6'
                          ,'Tech_7','Tech_8','Tech_9','Tech_10','Tech_11','Tech_12'];    // array index 0..12
    const researchLoopStart = 'Tech_Schleife_Bauzeit_Start';
    const researchLoopUntil = 'Tech_Schleife_Bauzeit_Bis';
    const researchLoopID = 'Tech_Schleife_ID';
    const researchLoopName = 'Tech_Schleife_Name';
    const researchLoopPlanet = 'Tech_Schleife_Planet';   // not used in code yet !?
    const researchCostIron = 'Tech_Schleife_Eisen';
	const researchCostSilicon ='Tech_Schleife_Silizium';
	const researchCostWater = 'Tech_Schleife_Wasser';
    const pointsStructure = 'punkte_structur';
    const pointsFleet = 'punkte_flotte';
    const pointsResearch = 'punkte_forschung';
}

?>
