<?php
class Termin
{
	public $id;
	public $benutzerId;
	public $hauspaketId;
	public $beraterId;
	public $endtime;
	public $starttime;
	public $description;
	
	public function __construct(){
		
	}
	
	public static function construct(
	$id,
	$benutzerId,
	$hauspaketId,
	$beraterId,
	$endtime,
	$starttime,
	$description){
		
		$obj = new Termin();
		
		$obj->id = $id;
		$obj->benutzerId = $benutzerId;
		$obj->hauspaketId = $hauspaketId;
		$obj->beraterId = $beraterId;
		$obj->endtime = $endtime;
		$obj->starttime = $starttime;
		$obj->description = $description;
		
		return $obj;
	}
	
	public function __get($name) {
	
		return $this->$name;
	}
	
	public function __set($name, $value) {
	
		$this->$name = $value;
	}
}
?>