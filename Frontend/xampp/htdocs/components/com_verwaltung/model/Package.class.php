<?php
class Package
{
	public $id;
	public $herstellerId;
	public $beraterId;
	public $bezeichnung;
	public $preis;
	public $grundflaeche;
	public $wohnflaeche;
	public $stockwerke;
	public $rating;
	public $attributes;
	
	public function __construct(){
		
	}
	
	public static function construct(
	$id,
	$herstellerId,
	$beraterId,
	$bezeichnung,
	$preis,
	$grundflaeche,
	$wohnflaeche,
	$stockwerke,
	$rating,
	$attributes){
		
		$obj = new Package();
		
		$obj->id = $id;
		$obj->herstellerId = $herstellerId;
		$obj->beraterId = $beraterId;
		$obj->bezeichnung = $bezeichnung;
		$obj->preis = $preis;
		$obj->grundflaeche = $grundflaeche;
		$obj->wohnflaeche = $wohnflaeche;
		$obj->stockwerke = $stockwerke;
		$obj->rating = $rating;
		$obj->attributes = $attributes;
		
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