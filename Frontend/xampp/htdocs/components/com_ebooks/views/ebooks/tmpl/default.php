<script>
function openPDF(filename)
{
	popup = window.open(filename,"","resizable=yes,scrollbars=Yes,menubar=no,toolbar=no,status=no,location=no");
}
</script>

<?php
// echo __DIR__;
// echo $_SERVER['DOCUMENT_ROOT'];
// No direct access to this file
//defined('_JEXEC') or die('Restricted access');
//include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
//include('C:/xampp/htdocs/Joomla/components/com_ebooks/inc/dbutil.php');
//include(JPATH_COMPONENT_SITE.'/model/Ebook.class.php');
//include('C:/xampp/htdocs/Joomla/components/com_ebooks/model/Ebook.class.php');
//echo urlencode("download2.pdf");

// echo $_SERVER['PHP_SELF'].'<br />'; 
// echo $_SERVER['DOCUMENT_ROOT'].'<br />';
// echo $_SERVER['HTTP_HOST'].'<br />';
// echo '</br>A</br>'  nge;
// echotcwd();
// echo realpath(getcwd() . "..\..\..\..\..\..\pdf\\elk.pdf");
// echo '</br>B/br>';
// echo 'C:/xampp/htdocs/pdf/elk.pdf';
// echo '</br>C/br>';
// if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/pdf/elk.pdf')){
	
//  	echo "tururururu <br />";
// }
// 	echo file_exists("localhost:8090/pdf/elk.pdf");
// }
// echo '------------------------------------';
// echo '<br /> <br />';

// $file = $_SERVER['HTTP_HOST']."/pdf/elk.pdf";
// echo $file;
// echo urlencode($file);
// if(isset($_GET['downloadfile'])){
// echo $_GET['downloadfile'].'<br />';
// }
	
if(isset($_GET['showPreview'])){
	insertEbookStatistic('Vorschau', $_GET['showPreview']);
	
	
}
if(isset($_GET['downloadfile'])){
// 	echo "did first step";

	
// 	echo file_exists(getcwd() . "../../../../../../pdf/elk.pdf");
// 	$file = $_SERVER['HTTP_HOST'] . '../../../../../pdf/elk.pdf';
// 	$file = $_SERVER['HTTP_HOST']  + "/pdf/elk.pdf";
// 	$file ="elk.pdf";
// 	$file= getcwd() . "../../../../../..//pdf/elk.pdf";
	
	
	$file = $_SERVER['DOCUMENT_ROOT'] . $_GET['downloadfile'];
	$filename = basename($file);
// 	$file = "WGG.pdf";
	header("Content-Type: application/octet-stream");

// 	$file = $_GET["file"] .".pdf";
// 	$file = "WGG.pdf";
	header("Content-Disposition: attachment; filename=" . urlencode($filename));   
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Description: File Transfer");            
	header("Content-Length: " . filesize($file));
	ob_end_flush();
	$fp = fopen($file, "r+");
	while (!feof($fp))
	{
	    echo fread($fp, 65536);
	    flush(); // this is essential for large downloads
	} 
	fclose($fp);
	
	if(isset($_GET['ebookId'])){
		insertEbookStatistic('Download', $_GET['ebookId']);
	}
}
?>
<h1>Downloadbereich f&uuml;r Ebooks</h1>

<form>


<?php 
	$allEbooks = getEbookList();
	foreach ($allEbooks as $aktEbook){
		?>
		<div style="width: 50%; float: left;">
		<div style="float: left;">
		<h2><?php echo $aktEbook->titel;?></h2>
		<p><span style="font-weight: bold;">Author: <?php echo $aktEbook->autor;?></span></br>
		<span><?php echo $aktEbook->auflage?>. Auflage</span></br>
		<span>Erscheinungsdatum: <?php echo formatDate($aktEbook->erscheinungsdatum)?></span></br>
			<div style="margin-bottom: 10px; width: 200px;">
			</div>
			</div>
			<div>
			<?php echo '<a href="'.$_SERVER['PHP_SELF'].'?ebookId='.$aktEbook->ebookId.'&downloadfile='.$aktEbook->content.'">';?>
		<img style="width: 110px;" src="<?php
			echo JURI::root () . 'images/ebook.png';
			?>">
			</a>
			<?php echo '<a href="'.$_SERVER['PHP_SELF'].'?showPreview='.$aktEbook->ebookId.'" onclick="openPDF(\''.$aktEbook->content.'\')">';?>
		<img style="width: 78px;" src="<?php
			echo JURI::root () . 'images/preview.png';
			?>">
			</a>
			</div>
			<hr>
		</div>
		<?php
	}
?>


</form>
<?php 
function formatDate($date){
	$formatDate = new DateTime($date);
	return $formatDate->format("d.m.Y");
}
?>
<?php



function getConnection(){
	
	/** PRODUKTIV */
 	$servername = "localhost:443";
 	$username = "root";
 	$password = "";
	
	/* TEST */
	//$servername = "localhost";
	//$username = "admin";
	//$password = "admin";
	
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
	$sql = "select count(*) as anz from ebook_statistic where statistik_typ = 'Download' and ebook_id = ".$ebookId;
	$result = $conn->query($sql);
			
	if ($result->num_rows > 0) {
		 $count = $result->fetch_object();
	}
	close($conn);
	return $count->anz;
}
function countEbookStatistic($ebookId){

	$conn = getConnection();
	$sql = "select count(*) as anz from ebook_statistic where statistik_typ = 'Vorschau' and ebook_id = ".$ebookId;
	$result = $conn->query($sql);
		
	if ($result->num_rows > 0) {
		$count = $result->fetch_object();
	}

	close($conn);
	return $count->anz;
}

function insertEbookStatistic($statistikTyp, $ebookId){
	$conn = getConnection();
	$sql = "insert into ebook_statistic (statistik_typ, ebook_id) values (?,?)";
	$benutzer_id = 810;
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("si", $statistikTyp, $ebookId);
	
	$success = $stmt->execute();
	
	$stmt->close();
	
	close($conn);
	
}


function close($conn){
	$conn->close();
}

?>
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