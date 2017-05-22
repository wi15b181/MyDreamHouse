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

function getAppointments(){
	$userId = getBenutzerId();
	
	$conn = getConnection ();
	
	$sql = "select t.hauspaket_id id,name,bezeichnung, DATE_FORMAT(starttime,'%d.%m.%Y') as tag,DATE_FORMAT(starttime,'%H:%i') as von,DATE_FORMAT(endtime,'%H:%i') as bis from termin t
				join hauspaket h on t.hauspaket_id = h.hauspaket_id
				join berater b on h.berater_id = b.berater_id
				join benutzer be on b.benutzer_id = be.benutzer_id
				join mdh_users users on be.joomla_user_id = users.id
				where t.benutzer_id = ".$userId." order by tag asc, von asc";
	
	$result = $conn->query ( $sql );


	if(null == $result){
		return array();
	}
	
	try{
	$resultArray = array ();
	
	if ($result->num_rows > 0) {
	
		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}


	}catch(Exception $e){
		close ( $conn );
		return array();
	}
	close ( $conn );
	
	return $resultArray;
}

function getFavoriten(){
	$userId = getBenutzerId();

	$conn = getConnection ();

	$sql = "select h.hauspaket_id as id,h.bezeichnung from favoriten f
		join hauspaket h on f.hauspaket_id = h.hauspaket_id where f.benutzer_id = ".$userId;

	$result = $conn->query ( $sql );


	if(null == $result){
		return array();
	}
	
	try{
	$resultArray = array ();

	if ($result->num_rows > 0) {

		while ( $row = $result->fetch_object () ) {
			array_push ( $resultArray, $row );
		}
	}
	
	}catch(Exception $e){
		close ( $conn );
		return array();
	}

	close ( $conn );

	return $resultArray;
}

function getContracts(){
	$userId = getBenutzerId();

	$conn = getConnection ();

	$sql = "select hk.termin_id, h.hauspaket_id as id,h.bezeichnung from hauskauf hk
		join termin t on hk.termin_id = t.termin_id
		join hauspaket h on t.hauspaket_id = h.hauspaket_id where hk.status != 'DRAFT' and t.benutzer_id = ".$userId;

	$result = $conn->query ( $sql );

 	if(null == $result){
 		return array();
 	}
 	
	$resultArray = array ();

	try{
		
		if ($result->num_rows > 0) {
	
			while ( $row = $result->fetch_object () ) {
				array_push ( $resultArray, $row );
			}
		}
	
	}catch(Exception $e){
		close ( $conn );
		return array();
	}
	close ( $conn );

	return $resultArray;
}

function close($conn) {
	$conn->close ();
}
?>