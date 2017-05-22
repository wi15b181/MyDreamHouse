<?php
class EbookStatistik
{
	public $statistikId;
	public $statistikTyp;
	public $benutzerId;
	public $ebookId;
	
	public function __construct(){
		
	}
	
	public static function construct(
	$statistikId,
	$statistikTyp,
	$benutzerId,
	$ebookId){
		
		$obj = new EbookStatistik();
		
		$obj->statistikId = $statistikId;
		$obj->statistikTyp = $statistikTyp;
		$obj->benutzerId = $benutzerId;
		$obj->ebookId = $ebookId;
		
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