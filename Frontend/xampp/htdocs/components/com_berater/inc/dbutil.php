<?php

include(JPATH_COMPONENT_SITE.'/model/Termin.class.php');

function getConnection(){
	$servername = "localhost:443";
	$username = "root";
	$password = "";
	$dbname = "joomla";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	mysqli_query($conn,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	return $conn;
}
function  getUserID($joomlaUID)
{
	$conn = getConnection();
	$sql = "select benutzer_id from benutzer where joomla_user_id = ".$joomlaUID;
	$result = $conn->query($sql);
	$benutzerID = array();
	if ($result->num_rows > 0) {
		$row = $result->fetch_object();
		$benutzerID = $row->benutzer_id;	
	}
	close($conn);
	return $benutzerID;
}

function getBeraterID($userID)
{
	$conn = getConnection();
	$sql = "select berater_id from berater where benutzer_id = ".$userID;
	$result = $conn->query($sql);
	$beraterID = array();
	if ($result->num_rows > 0) {
		$row = $result->fetch_object();
		$beraterID = $row->berater_id;
	}
	close($conn);
	return $beraterID;
}

function getTermine($beraterId){
	$conn = getConnection();
	
	$sql = "select * from termin where berater_id = ".$beraterId;
	$result = $conn->query($sql);
	$resultArray = array();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_object()) {
			$resultTermin = new Termin();
			$resultTermin = Termin::construct($row->termin_id, $row->benutzer_id, $row->hauspaket_id, $row->berater_id, $row->endtime, $row->starttime, $row->description);
			array_push($resultArray, $resultTermin);
		}
	}
	
	close($conn);
	
	return $resultArray;
}

function saveTermin($userID, $hpID, $berID, $desc, $start, $end)
{
	$conn = getConnection();
	$query = "INSERT INTO `termin` (`benutzer_id`, `hauspaket_id`, `berater_id`, `starttime`, `description`, `endtime`)";
	$query .= "VALUES (".$userID.", ".$hpID.", ".$berID.", '".$start."', '".$desc."', '".$end."')";
	$result = $conn->query($query);
	if($result)
		return $conn->insert_id;
	return $result;
}

function updateTermin($userID, $hpID, $berID, $desc, $start, $end, $id)
{
	$conn = getConnection();
	$query = "UPDATE `termin` SET `benutzer_id` = ".$userID.", `berater_id` = ".$berID.", `starttime` = '".$start."', `description` = '".$desc."', `endtime` = '".$end."' WHERE termin_id = ".$id;
	$result = $conn->query($query);
	if($result)
		return $conn->insert_id;
	return $result;
}

function checkTime($beraterID, $start, $end, $id = null)
{
	$conn = getConnection();
	$query = "SELECT * FROM `termin` WHERE `berater_id` = ".$beraterID." AND ((starttime >= '".$start."' AND starttime <= '".$end."') OR (endtime >= '".$start."' AND endtime <= '".$end."'))";
	if($id != null)
		$query .= " AND termin_id != ".$id; 
	
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		return false;
	}
	close($conn);
	return true;
}

function  deleteTermin($userID, $berID, $termID)
{
	$conn = getConnection();
	$query = "DELETE FROM `termin` WHERE `benutzer_id` = ".$userID." AND `berater_id` = ".$berID." AND `termin_id` = ".$termID;
	$result = $conn->query($query);
	return $result;	
}

function close($conn){
	$conn->close();
}

?>