<?php
class Ebook
{
	public $ebookId;
	public $titel;
	public $autor;
	public $erscheinungsdatum;
	public $auflage;
	public $bild;
	public $content;
	public $mimetype;
	public $size;
	public $active;
	
	public function __construct(){
		
	}
	
	public static function construct(
	$ebookId,
	$titel,
	$autor,
	$erscheinungsdatum,
	$auflage,
	$bild,
	$content,
	$mimetype,
	$size,
	$active){
		
		$obj = new Ebook();
		
		$obj->ebookId = $ebookId;
		$obj->titel = $titel;
		$obj->autor = $autor;
		$obj->erscheinungsdatum = $erscheinungsdatum;
		$obj->auflage = $auflage;
		$obj->bild = $bild;
		$obj->content = $content;
		$obj->mimetype = $mimetype;
		$obj->size = $size;
		$obj->active = $active;
		
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