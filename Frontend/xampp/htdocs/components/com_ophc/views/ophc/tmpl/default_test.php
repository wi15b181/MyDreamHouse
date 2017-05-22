<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>


<?php 

for($i = 0; $i < 100; $i++){
	$preis = rand(150000,850000);
	$gfl = rand(200,800);
	$wfl = rand(50,600);
	$stkw = rand(1,3);

	echo "insert into hauspaket(bezeichnung,preis,grundflaeche,wohnflaeche,stockwerke) values ('Hauspaket #".$i."',".$preis.",".$gfl.",".$wfl.",".$stkw.");";
	echo "</br>";
}


?>