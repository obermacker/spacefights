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

?>
