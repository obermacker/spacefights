ALTER TABLE `bauschleifedeff` RENAME `construction_loops_defense` ;
ALTER TABLE `construction_loops_defense` 
	CHANGE `ID` `id` INT(11) NOT NULL AUTO_INCREMENT,
	CHANGE `Spieler_ID` `player_id` VARCHAR(58) NOT NULL,
	CHANGE `Planet_ID` `planet_id` int(11) NOT NULL,
	CHANGE `Typ` `defense_id` int(11) NOT NULL,
	CHANGE `Eisen` `required_iron` bigint(20) NOT NULL,
	CHANGE `Silizium` `required_silicon` bigint(20) NOT NULL,
 	CHANGE `Wasser` `required_water` bigint(20) NOT NULL,
 	ADD `required_bots` INT(11) NOT NULL,
	CHANGE `Karma` `required_karma` int(11) NOT NULL,
	CHANGE `Name` `name` varchar(50) NOT NULL,
	CHANGE `Anzahl` `quantity` int(11) NOT NULL,
	CHANGE `Bauzeit_Von` `construction_time_start` int(9) NOT NULL,
	CHANGE `Bauzeit_Einzel` `construction_time` int(9) NOT NULL,
	CHANGE `Bauzeit_Bis` `construction_time_end` int(11) NOT NULL;
