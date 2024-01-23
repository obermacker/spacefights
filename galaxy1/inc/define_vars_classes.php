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

define('iron','iron');    define('water','water');  define('silicon','silicon');    define('energy','energy'); 
define('bots','bots');    define('kapa','kapa');    define('capacity','capacity');  define('karma','karma');
define('x','x');          define('y','y');          define('z','z');

class datasetPlanet {
	const database = 'galaxy1';
    const table = 'planet';

    const coordinates = ['x'=>'x','y'=>'y','z'=>'z'];
    const planetID = 'Planet_ID';
    const planetName = 'Planet_Name';
    const playerID = 'Spieler_ID';
    const playerName = 'Spieler_Name';

    const stationedBots = 'Stationiert_Bot';
    const stationedShipsType = ['1'=>'Schiff_Typ_1', '2'=>'Schiff_Typ_2', '3'=>'Schiff_Typ_3', '4'=>'Schiff_Typ_4', '5'=>'Schiff_Typ_5'
                                , '6'=>'Schiff_Typ_6', '7'=>'Schiff_Typ_7', '8'=>'Schiff_Typ_8', '9'=>'Schiff_Typ_9', '10'=>'Schiff_Typ_10'
                                , '11'=>'Schiff_Typ_11', '12'=>'Schiff_Typ_12'];
    const stationedDefencesType = ['1'=>'Deff_Typ_1', '2'=>'Deff_Typ_2', '3'=>'Deff_Typ_3', '4'=>'Deff_Typ_4', '5'=>'Deff_Typ_5', '6'=>'Deff_Typ_6'];

    const constructionLoopStart = 'Bauschleife_Gebaeude_Start';
    const constructionLoopUntil = 'Bauschleife_Gebaeude_Bis';
    const constructionLoopStructureID ='Bauschleife_Gebaeude_ID';
    const constructionLoopStructureName = 'Bauschleife_Gebaeude_Name';

    const LevelBuildingType = ['1'=>'Stufe_Gebaeude_1', '2'=>'Stufe_Gebaeude_2', '3'=>'Stufe_Gebaeude_3', '4'=>'Stufe_Gebaeude_4'
                                , '5'=>'Stufe_Gebaeude_5', '6'=>'Stufe_Gebaeude_6', '7'=>'Stufe_Gebaeude_7', '8'=>'Stufe_Gebaeude_8'
                                , '9'=>'Stufe_Gebaeude_10', '10'=>'Stufe_Gebaeude_10', '11'=>'Stufe_Gebaeude_11'];
    
    const resourcesProduction = ['iron'=>'Prod_Eisen', 'silicon'=>'Prod_Silizium', 'water'=>'Prod_Wasser','time'=>'Produktion_Zeit'];                                    
    const resourcesBasicProduction = ['iron'=>'Grund_Prod_Eisen', 'silicon' => 'Grund_Prod_Silizium', 'water'=>'Grund_Prod_Wasser'];
    const resourcesAvailable = ['iron'=>'Ressource_Eisen', 'silicon'=>'Ressource_Silizium', 'water'=>'Ressource_Wasser'
                                ,'energy'=>'Ressource_Energie', 'bots'=>'Ressource_Bot']; 
    const resourcesBunker = ['capacity'=>'Bunker_Kapa', 'iron'=>'Bunker_Eisen', 'silicon'=>'Bunker_Silizium', 'water'=>'Bunker_Wasser'];
    const resourcesTrading = ['capacity'=>'Handel_Kapa', 'iron'=>'Handel_Eisen', 'silicon'=>'Handel_Silizium', 'water'=>'Handel_Wasser'];

    // ************** not used in Game, but in Database present **************
    // const ID = 'ID'; // key field - autoincrement at database 
    // const constructionLoopFleetID = 'Bauschleife_Flotte_ID';
    // const points = 'punkte';
    // const totalBots = 'Gesamt_Bot';
    // const resourcesAvailable = [ .... , 'karma'=>'Ressource_Karma']; // **** karma resource is player not planet resource

    static array $coordinates;
    static $planetID;
    static $lanetName;
    static $layerID;
    static $layerName;
   
    static $stationedBots;
    static array $stationedShipsType = [];
    static array $stationedDefencesType;
    
    static array $resourcesProduction;
    static array $resourcesBasicProduction;
    static array $resourcesAvailable;
    static array $resourcesBunker;
    static array $resourcesTrading;

    static function loadRow($_row){
        foreach ($_row as $_column => $_value ){
            switch (true){
                case str_contains($_column, 'Schiff_Typ_'):
                    self::$stationedShipsType += [str_replace('Schiff_Typ_','',$_column) => $_value];
                    break;
            }
        }

    }
}

class datasetFleets {
	const database = 'galaxy1';
    const table = 'flotten';
    
    const ownerPlayerID = 'Spieler_ID';
    const ownerPlayerName = 'Besitzer_Spieler_Name';
    
    const departure = 'Start';
    const arrival = 'Ankunft';
    const mission = 'Mission';

    const loadingCapacity = 'Kapazitaet';
    const resourcesLoaded = ['iron'=>'Ausladen_Eisen', 'silicon'=>'Ausladen_Silizium', 'water'=>'Ausladen_Wasser'];
    const resourcesToCollect = ['iron'=>'Einladen_Eisen', 'silicon'=>'Einladen_Silizium', 'water'=>'Einladen_Wasser'];
   
    const ShipsInFleetType = ['1'=>'Schiff_Typ_1', '2'=>'Schiff_Typ_2', '3'=>'Schiff_Typ_3', '4'=>'Schiff_Typ_4', '5'=>'Schiff_Typ_5'
                                 , '6'=>'Schiff_Typ_6', '7'=>'Schiff_Typ_7', '8'=>'Schiff_Typ_8', '9'=>'Schiff_Typ_9', '10'=>'Schiff_Typ_10'
                                 , '11'=>'Schiff_Typ_11', '12'=>'Schiff_Typ_12'];

    const startPlanetID = 'Start_Planet_ID';
    const startPlanetName = 'Startplanet_Name';
    const startPlanetCoordinates = ['x'=>'x1','y'=>'y1','z'=>'z1'];
    
    const destinationPlanetID = 'Ziel_Planet_ID';
    const destinationPlanetName = 'Zielplanet_Name';
    const destinationPlanetCoordinates = ['x'=>'x2','y'=>'y2','z'=>'z2'];

    const destinationPlayerID = 'Ziel_Spieler_ID';
    const destinationPlayerName = 'Ziel_Spieler_Name';

    // ************** not used in Game, but in Database present **************
    // const ID = 'ID'; // key field - autoincrement at database 

    
    static array $start = [];
    static array $destination = [];
    static array $mission;
    static array $loadingCapacity;
    static array $resourcesLoaded = [];
    static array $resourcesToCollect = [];
    static array $ShipsInFleetType = [];

    static function loadRow($_row){
        foreach ($_row as $_column => $_value ){
            switch (true){
                case str_contains($_column, 'Schiff_Typ_'):
                    self::$stationedShipsType += [str_replace('Schiff_Typ_','',$_column) => $_value];
                    break;
            }
        }

    }
}

// datasetFleets::init();

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
    const techLevelType = ['1'=>'Tech_1','2'=>'Tech_2','3'=>'Tech_3','4'=>'Tech_4','5'=>'Tech_5','6'=>'Tech_6'
                          ,'7'=>'Tech_7','8'=>'Tech_8','9'=>'Tech_9','10'=>'Tech_10','11'=>'Tech_11','12'=>'Tech_12'];
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

    static $playerID;
    static $playerName;
    static $playerType;                           // not used in code yet !?
    static $playerImage;
    static $lastChosenPlanet;
    static $timestampBotProduction;
    static $techLevelType = [];
    static $researchLoopStart;
    static $researchLoopUntil;
    static $researchLoopID;
    static $researchLoopName;
    static $researchLoopPlanet;   // not used in code yet !?
    static $researchCostIron;
	static $researchCostSilicon;
	static $researchCostWater;
    static $pointsStructure;
    static $pointsFleet;
    static $pointsResearch;

    static function loadRow($_row){
        foreach ($_row as $_column => $_value ){
            switch (true){
                
                case str_contains($_column, 'Tech_Schleife_ID'):
                    self::$researchLoopID = $_value;
                    break;

                case str_contains($_column, 'Tech_'):
                    self::$techLevelType += [str_replace('Tech_','',$_column) => $_value];
                    break;
            }
        }

    }

}

?>
