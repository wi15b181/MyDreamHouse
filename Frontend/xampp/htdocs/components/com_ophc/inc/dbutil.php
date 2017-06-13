<?php
include (JPATH_COMPONENT_SITE . '/model/Package.class.php');
function getConnection() {
	$servername = "localhost:443";
	if (substr ( gethostname (), 0, 7 ) === "DESKTOP") {
		$servername = "localhost";
	}
	$username = "root";
	$password = "";
	$dbname = "joomla";
	
	// Create connection
	$conn = new mysqli ( $servername, $username, $password, $dbname );
	// Check connection
	if ($conn->connect_error) {
		die ( "Connection failed: " . $conn->connect_error );
	}
	
	mysqli_query ( $conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'" );
	return $conn;
}

function insertAttachement($fileInfoArray, $bezeichnung, $packageId) {
	$conn = getConnection ();
	
	$sql = "insert into attachements (filename,bezeichnung,size,mimetype,hauspaket_id) 
			values ( '" . $fileInfoArray ['name'] . "','" . $bezeichnung . "'," . $fileInfoArray ['size'] . ",'" . $fileInfoArray ['type'] . "'," . $packageId . ")";
	
	$result = $conn->query ( $sql );
}

function getPackage($packageId) {
	$conn = getConnection ();
	
	$sql = "select h.*,(select  round(avg(bewertung))  from bewertung where ref_id = " . $packageId . ") bewertung from hauspaket h where hauspaket_id = " . $packageId;
	$result = $conn->query ( $sql );
	
	$resultPackage = new Package ();
	
	if ($result->num_rows > 0) {
		$row = $result->fetch_object ();
		
		$attributes = getPackageAttributes ( $row->hauspaket_id );
		$resultPackage = Package::construct ( $row->hauspaket_id, $row->hersteller_id, $row->berater_id, $row->bezeichnung, $row->preis, $row->grundflaeche, $row->wohnflaeche, $row->stockwerke, $row->bewertung, $attributes );
	}
	close ( $conn );
	
	return $resultPackage;
}

function getAttachements($packageId){
	$conn = getConnection ();
	
	$sql = "select * from attachements where hauspaket_id = ".$packageId;
	
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	
	return $resultArray;
}

function deleteAttachement($attachementId){
	$conn = getConnection ();
	
	$sql = "delete from attachements where attachement_id = ".$attachementId;
	$result = $conn->query ( $sql );
	close ( $conn );
}

function getRatingForPackage($packageId) {
	$conn = getConnection ();
	
	$sql = "select COALESCE(round(avg(bewertung)),0) bewertung from bewertung where ref_id = " . $packageId;
	$result = $conn->query ( $sql );
	
	$ret = $result->fetch_object ()->bewertung;
	close ( $conn );
	
	return $ret;
}

function getRatingForBerater($beraterId) {
	$conn = getConnection ();
	
	$sql = "select COALESCE(round(avg(bewertung)),0) bewertung from bewertung where ref_id = " . $beraterId;
	$result = $conn->query ( $sql );
	
	$ret = $result->fetch_object ()->bewertung;
	close ( $conn );
	
	return $ret;
}
function canRate($refId, $joomlaBenutzerId) {
	$conn = getConnection ();
	
	$sql = "select * from bewertung where ref_id = " . $refId . " and benutzer_id = (select benutzer_id from benutzer where joomla_user_id = " . $joomlaBenutzerId . ")";
	
	$result = $conn->query ( $sql );
	
	$ret = true;
	
	if ($result->num_rows > 0) {
		$ret = false;
	}
	close ( $conn );
	
	return $ret;
}
function getCountRating($packageId) {
	$conn = getConnection ();
	
	$sql = "select count(*) anz from bewertung where ref_id = " . $packageId;
	$result = $conn->query ( $sql );
	
	$ret = $result->fetch_object ()->anz;
	close ( $conn );
	
	return $ret;
}
function getOpenDatesForDayAndConsultant($date, $beraterId) {
	$conn = getConnection ();
	
	$sql = "select DATE_FORMAT(starttime, '%H') as starttime,DATE_FORMAT(endtime, '%H') as endtime from termin where berater_id = " . $beraterId . " and starttime > STR_TO_DATE('" . $date . " 00:00', '%d.%m.%Y %H:%i') and endtime < DATE_ADD(STR_TO_DATE('" . $date . " 00:00', '%d.%m.%Y %H:%i') ,INTERVAL 1 DAY)";
	
	echo $sql;
	
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	
	return $resultArray;
}
function isConsultant($group) {
	$conn = getConnection ();
	
	$sql = "select * from mdh_usergroups where id = " . $group;
	$result = $conn->query ( $sql );
	
	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_object () ) {
			if ($row->title == 'Berater') {
				close ( $conn );
				return true;
			}
		}
	}
	
	return false;
}
function getConsultantForPackage($packageId) {
	$conn = getConnection ();
	
	$sql = "select berater_id,name,bild from berater b join benutzer be on b.benutzer_id = be.benutzer_id
			join mdh_users users on be.joomla_user_id = users.id where berater_id = (select berater_id from hauspaket where hauspaket_id = " . $packageId . ");";

	$result = $conn->query ( $sql );
	
	if ($result->num_rows > 0) {
		$berater = $result->fetch_object ();
		close ( $conn );
		return $berater;
	}
	
	return null;
}

function getBenutzerId() {
	$user = JFactory::getUser ();
	$userId = $user->id;
	$conn = getConnection ();
	
	$sql = "select benutzer_id from benutzer where joomla_user_id = " . $userId;
	$result = $conn->query ( $sql );
	
	$benutzerId = $result->fetch_object ()->benutzer_id;
	close ( $conn );
	return $benutzerId;
}

function saveRating($refId, $rating, $type) {
	$conn = getConnection ();
	$userId = getBenutzerId ();
	if (canRate ( $refId, $userId )) {
		$sql = "insert into bewertung (ref_id, bewertung_typ,bewertung, benutzer_id) values (" . $refId . ",'" . $type . "'," . $rating . "," . $userId . ");";
		$result = $conn->query ( $sql );
		close ( $conn );
	}
}

function saveFavorite($packageId) {
	$conn = getConnection ();
	$userId = getBenutzerId ();
	if (canFav ( $packageId, $userId )) {
		$sql = "insert into favoriten (hauspaket_id, benutzer_id) values (" . $packageId ."," . $userId . ");";
		$result = $conn->query ( $sql );
		close ( $conn );
	}
}

function canFav($packageId,$userId) {
	$conn = getConnection ();
	
	$sql = "select * from favoriten where hauspaket_id = " . $packageId . " and benutzer_id = ".$userId;
	
	$result = $conn->query ( $sql );
	
	$ret = true;
	
	if ($result->num_rows > 0) {
		$ret = false;
	}
	close ( $conn );
	
	return $ret;
	
}

function getPackageAttributes($packageId) {
	$conn = getConnection ();
	
	$sql = "select ha.attribut_typ,ha.attribut_typ_anzeige,haw.wert_id, haw.wert_text, haw.wert_ordnung from hauspaket_attribut_wert haw
			join hauspaket_attribut_zuord hazj on haw.wert_id = hazj.wert_id
			join hauspaket_attribut ha on haw.attribut_id = ha.attribut_id
			where hazj.hauspaket_id = " . $packageId . " order by ha.attribut_typ_anzeige desc,wert_ordnung desc";
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	return $resultArray;
}

function updateCustomerPackage($data){
	try{		
		
		$bauart = $data['PAR_BAUART'];
		$energie = $data['PAR_ENERGIEWERT'];
		$baumat = $data['PAR_BAUMATERIAL'];
		$konstrart = $data['PAR_KONSTRART'];
		$dachkonstr = $data['PAR_ARTDACHKONSTR'];
		$stockwerke = $data['PAR_STOCKWERKE'];	
		$packageId = $data['packageId'];
		
		updatePackageAttribute($packageId,'BAUART',$bauart);
		updatePackageAttribute($packageId,'ENERGIEWERT',$energie);
		updatePackageAttribute($packageId,'BAUMATERIAL',$baumat);
		updatePackageAttribute($packageId,'KONSTRART',$konstrart);
		updatePackageAttribute($packageId,'ARTDACHKONSTR',$dachkonstr);
		
		$conn = getConnection ();
		
		$sql = "update hauspaket set stockwerke = ".$stockwerke." where hauspaket_id = ".$packageId;
					
		$conn->query ( $sql );
		close ( $conn );
	}catch(Exception $e){
		echo $e;
	}
	return 'Erfolgreich gespeichert!';
}

function saveSale($data){	
	
	if(getSale($data['terminId']) != null){
		$sql = "update hauskauf set kaufpreis = '".$data['price']."', zahlungsvereinbarung = '".$data['payments']."' , anmerkungen = '".$data['remarks']."', kaufdatum = now(), status = '".$data['status']."' where termin_id = ".$data['terminId'];
	}else{
		$sql = "insert into hauskauf (termin_id,kaufpreis,zahlungsvereinbarung,anmerkungen,kaufdatum,status)
			values (".$data['terminId'].",'".$data['price']."','".$data['payments']."','".$data['remarks']."',now(),'".$data['status']."')";
	}
	$conn = getConnection ();
	
	$conn->query ( $sql );
	close ( $conn );	
}

function saveSalesMessage($data){	
	
	if(getSale($data['terminId']) != null){
		$sql = "update hauskauf set message = '".$data['message']."', status = '".$data['status']."' where termin_id = ".$data['terminId'];
	}else{
		die();
	}
	$conn = getConnection ();
	
	$conn->query ( $sql );
	addUserToGroup('Kaeufer');
	close ( $conn );	
}

function addUserToGroup($group){
	$conn = getConnection ();
	
	$sql = "select * from mdh_usergroups where title = '" . $group."'";
	
	$result = $conn->query ( $sql );
	
	if ($result->num_rows > 0) {
		$group_id = $result->fetch_object()->id;
	}
	
	$user = JFactory::getUser ();
	$userId = $user->id;
	
	jimport( 'joomla.user.helper' );
	JUserHelper::addUserToGroup($userId, $group_id);
}

function getSale($terminId){
	$conn = getConnection ();

	$sql = "select * from hauskauf where termin_id = ".$terminId;

	$result = $conn->query ( $sql );
	if ($result->num_rows == 0) {
		return null;
	}
	$sale = $result->fetch_object();
	
	close ( $conn );
	
	return $sale;
}

function updatePackageAttribute($packageId,$attribute_typ,$attribute_value){
	$conn = getConnection ();
	
	$sql = "update hauspaket_attribut_zuord haz
				join hauspaket_attribut_wert haw on haz.wert_id = haw.wert_id
				join hauspaket_attribut ha on haw.attribut_id = ha.attribut_id
				set haz.wert_id = ".$attribute_value." where haz.hauspaket_id = ".$packageId." and ha.attribut_typ = '".$attribute_typ."'";
	
	$result = $conn->query ( $sql );
	close ( $conn );
}

function saveAppointment($packageId, $day, $time) {
	$timeFrom = $time . ":00";
	$timeTo = sprintf ( '%02d', ltrim ( $time, '0' ) + 1 ) . ":00";
	
	$starttime = $day . " " . $timeFrom;
	$endtime = $day . " " . $timeTo;
	
	$userId = getBenutzerId ();
	
	$conn = getConnection ();
	
	$checkSql = "select * from termin where hauspaket_id = " . $packageId . " and benutzer_id = " . $userId;
	$result = $conn->query ( $checkSql );
	
	if ($result->num_rows > 0) {
		return "Sie haben Bereits einen Termin zu diesem Hauspaket eingetragen!";
	}
	
	close ( $conn );
	$copySql = "CALL joomla.copyPackage(" . $packageId . ", " . $userId . ", @outId);";
		
	$conn = getConnection ();
	$conn->query ( $copySql );
	$outResult = $conn->query ( "SELECT @outId" );
	
	$newPackageId = $outResult->fetch_row () [0];
	
	close ( $conn );
	
	$user = JFactory::getUser ();
	
	$sql = "insert into termin (benutzer_id, hauspaket_id, starttime, berater_id, endtime, description)
			values (" . $userId . "," . $newPackageId . ",STR_TO_DATE('" . $starttime . "','%d.%m.%Y %H:%i'),
					(select berater_id from hauspaket where hauspaket_id = " . $newPackageId . "),
							STR_TO_DATE('" . $endtime . "','%d.%m.%Y %H:%i'),'" . $user->name . "')";
	
	$conn = getConnection ();
	
	$result = $conn->query ( $sql );
	
	close ( $conn );
	
	return "Termin erfolgreich gespeichert! ";
}
function getAttributeTypes() {
	$conn = getConnection ();
	
	$sql = "select * from hauspaket_attribut where attribut_typ NOT LIKE 'EXTRA_%'";
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	return $resultArray;
}
function getAttributeValues($attr) {
	$conn = getConnection ();
	$sql = "select * from hauspaket_attribut_wert where attribut_id = " . $attr->attribut_id . " order by wert_ordnung";
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	return $resultArray;
}
function getExtras() {
	$conn = getConnection ();
	
	$sql = "select * from hauspaket_attribut where attribut_typ LIKE 'EXTRA_%'";
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	return $resultArray;
}
function getRules() {
	$conn = getConnection ();
	
	$sql = "select * from hauspaket_attribut_regel";
	$result = $conn->query ( $sql );
	
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
		
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	close ( $conn );
	return $resultArray;
}
function close($conn) {
	$conn->close ();
}

?>