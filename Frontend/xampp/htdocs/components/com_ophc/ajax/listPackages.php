<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
queryPackages();

function queryPackages(){
	$conn = getConnection();		
	$result = $conn->query(getSQL());
	
	
	//echo $_GET['PAR_EXTRA_GARAGE'];
	//echo $_GET['PAR_EXTRA_KELLER'];
	//echo $_GET['PAR_EXTRA_POOL'];
	//echo $_GET['PAR_EXTRA_GARTENGESTALTUNG'];
	//echo $_GET['PAR_EXTRA_KELLER'];
	
	// START - - Add by Adnan Jusic related to FST 04; 19.06.2017 //
	$multiplikationswert = 0.00;
	$paramausbaustufe = $_GET['PAR_AUSBAUSTUFE'];
	
	
	if(isset($paramausbaustufe)){

	echo $_GET['PAR_AUSBAUSTUFE'];
	
	$sqlQueryausbaustufe = "SELECT regel_preis_modifikator FROM joomla.hauspaket_attribut_regel WHERE regel_attribut_left_id = '$paramausbaustufe'";
	$resultausbaustufe = $conn->query($sqlQueryausbaustufe);
	// echo $sqlQueryausbaustufe;
	if ($resultausbaustufe->num_rows > 0) {
		
		while($row = $resultausbaustufe->fetch_assoc()){
			//echo $row["regel_preis_modifikator"];
			$multiplikationswert = $row["regel_preis_modifikator"];
		}
		
	}
	echo $multiplikationswert;
	echo "Test Ende";		
	}
	
	// END - - Add by Adnan Jusic related to FST 04; 19.06.2017 //

		
	echo '<span class="span-result">Ihre Suche ergab '.$result->num_rows.' Treffer: </span>';
	echo '<br/>';
	echo '<br/>';
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_object()) {
			
			$attributes = getPackageAttributes($row->hauspaket_id);
			$rating = getRatingForPackage($row->hauspaket_id);
			$package = Package::construct($row->hauspaket_id, $row->hersteller_id, $row->berater_id, $row->bezeichnung, $row->preis, $row->grundflaeche, $row->wohnflaeche, $row->stockwerke, $rating,$attributes);		
			?>
			
			<div class="package-tile">	
				<div class="energy-div">
					<img class="energy"
						src="<?php 
						foreach($package->attributes as $attr){
							if($attr->attribut_typ == 'ENERGIEWERT'){								
								echo JURI::root().'images/ophc/'.$attr->wert_ordnung;
							}
						}						
						?>.jpg">
				</div>
				<img class="preview"
						src="<?php 
						echo JURI::root().'images/ophc/housetypes/'.rand(1,9);
						?>.jpg">
				<div class="tile-content">	
					<div class="package-title">
						<span><?php echo $package->bezeichnung;?></span>		
						<div class="star-container tile-star">
						    <input type="radio" name="<?php echo $package->bezeichnung?>" <?php if($package->rating == 1)echo 'checked="checked"'?> class="rating" value="1" />
						    <input type="radio" name="<?php echo $package->bezeichnung?>" <?php if($package->rating == 2)echo 'checked="checked"'?> class="rating" value="2" />
						    <input type="radio" name="<?php echo $package->bezeichnung?>" <?php if($package->rating == 3)echo 'checked="checked"'?> class="rating" value="3" />
						    <input type="radio" name="<?php echo $package->bezeichnung?>" <?php if($package->rating == 4)echo 'checked="checked"'?> class="rating" value="4" />
						    <input type="radio" name="<?php echo $package->bezeichnung?>" <?php if($package->rating == 5)echo 'checked="checked"'?> class="rating" value="5" />
						</div>
					</div>			
				</div>
				<div class="tile-footer">
					<div class="tile-footer-section part-1">
						<div>
							<span><?php echo number_format($package->wohnflaeche);?>m<sup>2</sup></span>
						</div>
					</div>
					<div class="tile-footer-section part-2">
						<div>
							<span><?php
							if($multiplikationswert <= 0){
								echo ' &euro; '.number_format($package->preis,0,',','.').' ';	
							}else{
								$preis_alt = $package->preis;
								$preis_neu = $preis_alt - ($preis_alt * ($multiplikationswert / 100));
								echo ' &euro; '.number_format($preis_neu,0,',','.').' ';
							}
							?></span>
						</div>
					</div>
					<div class="tile-footer-section part-3">
						<div>
							<span>
					<?php echo '<a onclick="augmentLink(this)"; href="'.$_SERVER['PHP_SELF'].'?showDetail='.$row->hauspaket_id.'" style="text-decoration:none; font-size: 1.1em;">Details</a>'; ?>
					</span>
						</div>
					</div>
				</div>
			</div>
			<?php 
			//echo '<a onclick="augmentLink(this)"; href="'.$_SERVER['PHP_SELF'].'?showDetail='.$row->hauspaket_id.'" style="text-decoration:none;">';
			
							
		}
	}else{
		echo 'no data found';
	}
	
}

function getSQL(){
	$sqlQuery = "select * from hauspaket hp";
	
	$and = false;
		
	if(isset($_GET['PAR_BAUART']) && !empty($_GET['PAR_BAUART'])){
		$sqlQuery = appendCriteria($sqlQuery, $_GET['PAR_BAUART'], $and);
		$and = true;
	}
	if(isset($_GET['PAR_ENERGIEWERT']) && !empty($_GET['PAR_ENERGIEWERT'])){
		$sqlQuery = appendEnergieCriteria($sqlQuery, $_GET['PAR_ENERGIEWERT'], $and);
		$and = true;
	}
	if(isset($_GET['PAR_BAUMATERIAL']) && !empty($_GET['PAR_BAUMATERIAL'])){
		$sqlQuery = appendCriteria($sqlQuery, $_GET['PAR_BAUMATERIAL'], $and);
		$and = true;
	}
	if(isset($_GET['PAR_KONSTRART']) && !empty($_GET['PAR_KONSTRART'])){
		$sqlQuery = appendCriteria($sqlQuery, $_GET['PAR_KONSTRART'], $and);
		$and = true;
	}
	if(isset($_GET['PAR_ARTDACHKONSTR']) && !empty($_GET['PAR_ARTDACHKONSTR'])){
		$sqlQuery = appendCriteria($sqlQuery, $_GET['PAR_ARTDACHKONSTR'], $and);
		$and = true;
	}

	if(isset($_GET['PAR_PRICE']) && !empty($_GET['PAR_PRICE'])){
		$sqlQuery = appendSpecialCriteria($sqlQuery, $_GET['PAR_PRICE'],'PAR_PRICE', $and);
		$and = true;
	}
	
	if(isset($_GET['PAR_PRICE_MAX']) && !empty($_GET['PAR_PRICE_MAX'])){
		$sqlQuery = appendSpecialCriteria($sqlQuery, $_GET['PAR_PRICE_MAX'],'PAR_PRICE_MAX', $and);
		$and = true;
	}
	
	if(isset($_GET['PAR_GROUNDAREA']) && !empty($_GET['PAR_GROUNDAREA'])){
		$sqlQuery = appendSpecialCriteria($sqlQuery, $_GET['PAR_GROUNDAREA'],'PAR_GROUNDAREA', $and);
		$and = true;
	}
	
	if(isset($_GET['PAR_GROUNDAREA_MAX']) && !empty($_GET['PAR_GROUNDAREA_MAX'])){
		$sqlQuery = appendSpecialCriteria($sqlQuery, $_GET['PAR_GROUNDAREA_MAX'],'PAR_GROUNDAREA_MAX', $and);
		$and = true;
	}
	
	if(isset($_GET['PAR_LIVINGAREA']) && !empty($_GET['PAR_LIVINGAREA'])){
		$sqlQuery = appendSpecialCriteria($sqlQuery, $_GET['PAR_LIVINGAREA'],'PAR_LIVINGAREA', $and);
		$and = true;
	}
	
	if(isset($_GET['PAR_LIVINGAREA_MAX']) && !empty($_GET['PAR_LIVINGAREA_MAX'])){
		$sqlQuery = appendSpecialCriteria($sqlQuery, $_GET['PAR_LIVINGAREA_MAX'],'PAR_LIVINGAREA_MAX', $and);
		$and = true;
	}
	
	$sqlQuery = appendFixedCriteria($sqlQuery, 'benutzer_id is null', $and);
	
	return $sqlQuery;
}

function appendAusbaustufe($sqlQuery, $crit, $and){

	$sqlQuery = appendAnd($sqlQuery,$and);
	
	$sqlQuery = $sqlQuery.' '.$crit.' ';
	
	return $sqlQuery;
}

function appendFixedCriteria($sqlQuery, $crit, $and){

	$sqlQuery = appendAnd($sqlQuery,$and);
	
	$sqlQuery = $sqlQuery.' '.$crit.' ';
	
	return $sqlQuery;
}

function appendCriteria($sqlQuery, $crit, $and){
	
	$sqlQuery = appendAnd($sqlQuery,$and);
	
	$sqlQuery = $sqlQuery.'exists (select 1 from hauspaket_attribut_zuord haz where haz.hauspaket_id = hp.hauspaket_id and wert_id = '.$crit.')';
	
	return $sqlQuery;
}

function appendEnergieCriteria($sqlQuery, $crit, $and){

	$sqlQuery = appendAnd($sqlQuery,$and);

	$sqlQuery = $sqlQuery.'exists (select 1 from hauspaket_attribut_zuord haz where haz.hauspaket_id = hp.hauspaket_id and wert_id in 
			(select we2.wert_id from hauspaket_attribut_wert we 
			join hauspaket_Attribut_wert we2 on we.attribut_id = we2.attribut_id
			where we.wert_id = '.$crit.' 
			and we2.wert_ordnung <= we.wert_ordnung))';

	return $sqlQuery;
}

function appendSpecialCriteria($sqlQuery, $crit, $critName, $and){
	
	$sqlQuery = appendAnd($sqlQuery,$and);
	
	switch ($critName) {
		case 'PAR_PRICE':
			$sqlQuery = $sqlQuery.'preis > '.$crit;
		break;		
		case 'PAR_PRICE_MAX':
			$sqlQuery = $sqlQuery.'preis < '.$crit;
		break;		
		case 'PAR_GROUNDAREA':
			$sqlQuery = $sqlQuery.'grundflaeche > '.$crit;
		break;			
		case 'PAR_GROUNDAREA_MAX':
			$sqlQuery = $sqlQuery.'grundflaeche < '.$crit;
		break;	
		case 'PAR_LIVINGAREA':
			$sqlQuery = $sqlQuery.'wohnflaeche > '.$crit;
		break;		
		case 'PAR_LIVINGAREA_MAX':
			$sqlQuery = $sqlQuery.'wohnflaeche < '.$crit;
		break;	
		default:
			$sqlQuery = $sqlQuery.'1=1 ';
			;
		break;
	}
	
	return $sqlQuery;
}

function appendAnd($sqlQuery, $and){

	if($and){
		$sqlQuery = $sqlQuery.' and ';
	}else{
		$sqlQuery =$sqlQuery.' where ';
	}
	
	return $sqlQuery;
}

?>