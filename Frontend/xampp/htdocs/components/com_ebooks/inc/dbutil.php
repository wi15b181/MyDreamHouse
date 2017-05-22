<?php

include(JPATH_COMPONENT_SITE.'/model/Ebook.class.php');
//include('C:/xampp/htdocs/Joomla/components/com_ebooks/model/Ebook.class.php');

function getConnection(){
	$servername = "localhost";
	$username = "admin";
	$password = "admin";
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

function getEbookList(){
	$conn = getConnection();
	
	$sql = "select * from ebook";
	$result = $conn->query($sql);
	$allEbooks = array();
	
	$resultEbook = new Ebook();
	
	for($i = 0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_object();
		
		$resultEbook = Ebook::construct($row->ebook_id, $row->titel, $row->autor, $row->erscheinungsdatum, $row->auflage, $row->bild, $row->content, $row->mimetype, $row->size, $row->active);	
		array_push($allEbooks, $resultEbook);
	}	
	
// 	var_dump($allEbooks);
	close($conn);
	
	return $allEbooks;
}

function countEbook($ebookId){

	$conn = getConnection();
	$sql = "select count(*) as anz from ebook_statistic where ebook_id = ".$ebookId;
	$result = $conn->query($sql);
			
	if ($result->num_rows > 0) {
		 $count = $result->fetch_object();
	}
	
	close($conn);
	return $count->anz;
}

function getAttributeTypes(){

	$conn = getConnection();
	
	$sql = "select * from hauspaket_attribut";
	$result = $conn->query($sql);
	
	$resultArray = array();
	
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_object()) {
			array_push($resultArray, $row);
		}
		
	} 	
	
	close($conn);
	return $resultArray;
}

function getAttributeValues($attr){
	
	$conn = getConnection();
	$sql = "select * from hauspaket_attribut_wert where attribut_id = ".$attr->attribut_id;
	$result = $conn->query($sql);
	
	$resultArray = array();
	
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_object()) {
			array_push($resultArray, $row);
		}	
	}
	
	close($conn);
	return $resultArray;
}

function close($conn){
	$conn->close();
}

?>



 <?php
//  countEbook(1);
 ?>