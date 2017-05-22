<?php
		for($i = 0; $i < 100; $i++){
			$preis = rand(150000,850000);
			$gfl = rand(200,800);
			$wfl = rand(50,600);
			$stkw = rand(1,3);
			
			$a = rand(1,3);
			$b = rand(5,9);
			$c = rand(10,13);
			$d = rand(14,15);
			$e = rand(17,24);
			
			
		
			echo "insert into hauspaket(bezeichnung,preis,grundflaeche,wohnflaeche,stockwerke) values ('Hauspaket #".$i."',".$preis.",".$gfl.",".$wfl.",".$stkw.");";
			echo "</br>";
			echo "insert into hauspaket_attribut_zuord values ((select max(hauspaket_id) from hauspaket),".$a.");";
			echo "</br>";
			echo "insert into hauspaket_attribut_zuord values ((select max(hauspaket_id) from hauspaket),".$b.");";
			echo "</br>";
			echo "insert into hauspaket_attribut_zuord values ((select max(hauspaket_id) from hauspaket),".$c.");";
			echo "</br>";
			echo "insert into hauspaket_attribut_zuord values ((select max(hauspaket_id) from hauspaket),".$d.");";
			echo "</br>";
			echo "insert into hauspaket_attribut_zuord values ((select max(hauspaket_id) from hauspaket),".$e.");";
			echo "</br>";
		}
?>