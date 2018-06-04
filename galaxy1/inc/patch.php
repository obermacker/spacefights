<BR><BR><BR><BR>
<table width=50% align=center>
	<tr>
		<td colspan = 2 >Planet</td>
		<td colspan = 3>Resourcen Produktion ALT</td>
		<td colspan = 3>Resourcen Produktion NEU</td>
	</tr>
	<tr>
		<td>Name</td>
		<td>Kordinaten</td>
		<td>Eisen</td>
		<td>Silikon</td>
		<td>Wasser</td>
		<td>Eisen</td>
		<td>Silikon</td>
		<td>Wasser</td>
	</tr>
	<?php
	// quick and dirty : Produktionszahlen auf allen Planeten korregieren ;-)

	require 'inc/connect_galaxy_1.php';
	
	$query = "SELECT `ID`, `Planet_Name`, `x`, `y`, `z`, `Stufe_Gebaeude_1`, `Stufe_Gebaeude_2`, `Stufe_Gebaeude_3`, `Prod_Eisen`, `Prod_Silizium`, `Prod_Wasser` FROM `planet` WHERE 1";
	$result = mysqli_query($link, $query) or sql_fehler(mysqli_error($link) , __FILE__ ,  __LINE__ );

	while ($row = mysqli_fetch_object($result)){
		$temp['Stufe_Gebaeude_1'] = $row->Stufe_Gebaeude_1;
		$temp['Stufe_Gebaeude_2'] = $row->Stufe_Gebaeude_2;
		$temp['Stufe_Gebaeude_3'] = $row->Stufe_Gebaeude_3;
		
		echo "<tr>";
			echo "<td>" . $row->Planet_Name . "</td>" ;
			echo "<td>" . $row->x . ":" . $row->y . ":" . $row->z . "</td>";
			echo "<td>" . $row->Prod_Eisen . "</td>" ;
			echo "<td>" . $row->Prod_Silizium . "</td>" ;
			echo "<td>" . $row->Prod_Wasser . "</td>" ;
			
			if ($temp['Stufe_Gebaeude_1'] >0) {$Prod_Eisen = 20;} else {$Prod_Eisen = 0;}
			if ($temp['Stufe_Gebaeude_2'] >0) {$Prod_Silizium = 10;} else {$Prod_Silizium = 0;}
			if ($temp['Stufe_Gebaeude_3'] >0) {$Prod_Wasser = 5;} else {$Prod_Wasser = 0;}			
			$temp['Prod_Eisen'] = $Prod_Eisen;
			$temp['Prod_Silizium'] = $Prod_Silizium;
			$temp['Prod_Wasser'] = $Prod_Wasser;
			
			$mod_gewinn_ress = 1.35;
					
			for ($Baustufe = 2; $Baustufe <= $temp['Stufe_Gebaeude_1']; $Baustufe++){
				$Prod_Eisen *= $mod_gewinn_ress ;
				$temp['Prod_Eisen'] += round($Prod_Eisen);
			}
			for ($Baustufe = 2; $Baustufe <= $temp['Stufe_Gebaeude_2']; $Baustufe++){
				$Prod_Silizium *= $mod_gewinn_ress ;
				$temp['Prod_Silizium'] += round($Prod_Silizium);
			}
			for ($Baustufe = 2; $Baustufe <= $temp['Stufe_Gebaeude_3']; $Baustufe++){
				$Prod_Wasser *= $mod_gewinn_ress ;
				$temp['Prod_Wasser'] += round($Prod_Wasser);	
			}

			$temp['Prod_Eisen'] = round($temp['Prod_Eisen']);
			$temp['Prod_Silizium'] = round($temp['Prod_Silizium']);
			$temp['Prod_Wasser'] = round($temp['Prod_Wasser']);
			
			echo "<td>" . $temp['Prod_Eisen'] . "</td>" ;
			echo "<td>" . $temp['Prod_Silizium'] . "</td>" ;
			echo "<td>" . $temp['Prod_Wasser'] . "</td>" ;
		echo "</tr>";

		$query = "UPDATE `planet` SET
			`Prod_Eisen` = " . $temp['Prod_Eisen'] . ",
			`Prod_Silizium` = " . $temp['Prod_Silizium'] . ",
			`Prod_Wasser` = " . $temp['Prod_Wasser'] . "
			WHERE `ID` = " . $row->ID;
		
		mysqli_query($link, $query) or die (mysqli_error($link));
	}
	?>
</table>
	
