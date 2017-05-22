<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.access.access' );

$user = JFactory::getUser ();

$isConsultant = false;
foreach ( $user->getAuthorisedGroups () as $group ) {
	$isConsultant = $isConsultant || isConsultant ( $group );
}

if (! $isConsultant) {
	echo "Unauthorized";
	die ();
}
$package = new Package ();
$terminId = null;
$sale;

if ((isset ( $_GET ['showDetail'] ) && ! empty ( $_GET ['showDetail'] )) && ( $_GET ['termin'] ) && ! empty ( $_GET ['termin'] )) {
	$package = getPackage ( $_GET ['showDetail'] );
	$terminId = $_GET ['termin'];
	
	$saleTemp = getSale($terminId);
	if($saleTemp != null){
		$sale = $saleTemp;
	}
	
} else {
	echo "Hauspaket konnte nicht geladen werden.";
	die ();
}

?>
<?php
// Check if image file is a actual image or fake image
if (isset ( $_POST ["submit"] )) {
	jimport ( 'joomla.filesystem.file' );
	
	$jinput = JFactory::getApplication ()->input;
	$fileInput = new JInput ( $_FILES );
	$file = $fileInput->get ( 'attachement', null, 'array' );
	
	if (isset ( $file ) && ! empty ( $file ['name'] )) {
		$filename = JFile::makeSafe ( $file ['name'] );
		$src = $file ['tmp_name'];
		$data ['fileToUpload'] = $filename;
		
		$dest = JPATH_ROOT . '/' . 'uploads' . '/' . $filename;
		
		if (JFile::upload ( $src, $dest )) {
			insertAttachement ( $file, $file ['name'], $package->id );
		}
	}
}

if(isset ($_POST['delete'])){
	deleteAttachement($_POST['delete']);
}
?>
<h1>Planungsblatt</h1>
<div class="package-detail">
	<div class="package-detail-header">
		<span class="package-title"><?php echo $package->bezeichnung;?></span>
	</div>
	<div class="package-detail-content">
	<div id="info-div">
	
	</div>
	<br/>
	<div class="ophc-detail-all">
			<div class="ophc-detail-left">
			<?php
			
			$attributeTypes = getAttributeTypes ();
			foreach ( $attributeTypes as $attr ) {	
				$selectedValue = null;
				foreach($package->attributes as $pAttr){
					if($pAttr->attribut_typ == $attr->attribut_typ){
						$selectedValue = $pAttr->wert_id;
					}
				}
				?>
				<label class="ophc-form-label ">
				<?php echo $attr->attribut_typ_anzeige?>
				</label>
				<?php
				if(isset($sale) && $sale->status != 'DRAFT'){
					echo '<select disabled="disabled" class="ophc-detail-form-elem" id="PAR_' . $attr->attribut_typ . '" name="PAR_' . $attr->attribut_typ . '" value="'.$selectedValue.'">';
				}else{
					echo '<select class="ophc-detail-form-elem" id="PAR_' . $attr->attribut_typ . '" name="PAR_' . $attr->attribut_typ . '" value="'.$selectedValue.'">';
				}
				?>
						<?php
				$attributes = getAttributeValues ( $attr );
				foreach ( $attributes as $attrVal ) {
					if($selectedValue == $attrVal->wert_id){
						echo '<option selected="selected" value="' . $attrVal->wert_id . '">' . $attrVal->wert_text . '</option>';
					}else{
						echo '<option value="' . $attrVal->wert_id . '">' . $attrVal->wert_text . '</option>';
					}
				}
				?>
				</select>
				<?php
			}
			?>
	
		<label class="ophc-form-label" for="PAR_STOCKWERKE">Anzahl der Stockwerke: </label>
		<?php 
		if(isset($sale) && $sale->status != 'DRAFT'){		
		?>
		<input disabled="disabled" min="0" max="3" style="width: 30px;" type="number" id="PAR_STOCKWERKE" value="<?php echo $package->stockwerke;?>">
		<?php 
		}else{
		?>		
		<input min="0" max="3" style="width: 30px;" type="number" id="PAR_STOCKWERKE" value="<?php echo $package->stockwerke;?>">
		<?php 
		}?>
		</div>
		<div class="ophc-detail-right">
				<label class="ophc-form-label ">Anmerkungen (max. 1024 Zeichen)</label>				
				<textarea <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> placeholder="z.B. Kunde besteht auf zertifizierte Subunternehmer" maxlength="1024" id="remarks" style="width: 550px; height: 110px; resize: none;"><?php if(isset($sale)){echo $sale->anmerkungen;}?></textarea>
			
				<label class="ophc-form-label ">Zahlungsvereinbarung (max. 1024 Zeichen)</label>
				<textarea <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?>placeholder="z.B. 3% Rabatt bei Zahlung binnen 21 Tagen." maxlength="1024" id="payments" style="width: 550px; height: 110px; resize: none;"><?php if(isset($sale)){echo $sale->zahlungsvereinbarung;}?></textarea>
				
				<label class="ophc-form-label" for="price">Gesamtpreis: </label>
				<input <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> placeholder="z.B. 400.000,- exkl. USt." value="<?php if(isset($sale)){echo $sale->kaufpreis;}?>" type="text" id="price" value="">
		
		</div>
	</div>
	
	<div class="ophc-detail-all">
		<div id="attachements">
			<h1>Anh&auml;nge</h1>
			<hr />
			
			<?php 
			$attachements = getAttachements($package->id);
			
			foreach ($attachements as $attachement){?>

				<img style="float: left; margin-right: 5px; width: 20px;"
						src="<?php
					echo JURI::root () . 'images/ophc/file.png'?>">
				<div class="files-list-div file-list">
				<a target="_blank" href="uploads/<?php echo $attachement->filename;?>"> <?php echo $attachement->bezeichnung;?></a>
				</div>
				<div class="delete-attachement-button">
					<form action="" method="post"><input <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> type="hidden" name="delete" value="<?php echo $attachement->attachement_id;?>"/><input type="submit" value="x"></form>
				</div>
				
				
				<?php 
			}
			?>
			
			<div id="fileslistdiv">
				<img style="float: left; margin-right: 5px; width: 20px;"
					src="<?php
					echo JURI::root () . 'images/ophc/file.png'?>">
				<div id="fileslist" class="files-list-div"></div>
			</div>
			<form action="" method="post" enctype="multipart/form-data">
				<div class="fileUpload form-btn">
					<span>Datei ausw&auml;hlen</span> <input <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> class="upload" type="file"
						name="attachement" id="attachement">
				</div>
				<input <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> onclick="save(); return true;" class="form-btn" type="submit" value="Anh&auml;ngen"
					name="submit">
			</form>
		</div>
		</div>
		<hr/>
		
		<div class="ophc-detail-all">
			<div id="menu-div">
				<a href="index.php/berater-termine"><button style="float: left;" class="form-btn">Zur&uuml;ck</button></a>
				<button <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> style="float: right;" onclick="save()" class="form-btn">Zwischenspeichern</button>
				<button <?php if(isset($sale) && $sale->status != 'DRAFT'){echo ' disabled="disabled" ';}?> style=" float: right; margin-right: 20px;" onclick="finish()" class="form-btn finish">Abschluss</button>
			</div>
		</div>
	</div>
</div>

<script>

function save(){
	jQuery(function(){
	var params = '?task=saveCustomerPackage&format=raw';

	params += getParamList();

	params += '&packageId=<?php echo $package->id;?>';
	params += '&terminId=<?php echo $terminId;?>';
	params += '&status=<?php echo 'DRAFT';?>';
	
	var url = '<?php echo $_SERVER['PHP_SELF'];?>';
	
	url+=params;

	jQuery.ajax({
		  url: url,
		  data: { price: jQuery('#price').val(), remarks: jQuery('#remarks').val(), payments: jQuery('#payments').val()},
		  context: document.body
		}).done(function(content) {
			jQuery('#info-div').html(
			'<div class="success-info">'+'<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>'+
			'<strong>Info: </strong> '+content+'</div>');
			
			},true);
	});	
}

function finish(){
	if(confirm("Auftrag finalisieren?")){
		jQuery(function(){
			var params = '?task=saveSale&format=raw';

			params += '&terminId=<?php echo $terminId;?>';
			params += '&status=<?php echo 'FINALIZED';?>';
			
			var url = '<?php echo $_SERVER['PHP_SELF'];?>';
			
			url+=params;

			jQuery.ajax({
				  method: "GET",
				  url: url,
				  data: { price: jQuery('#price').val(), remarks: jQuery('#remarks').val(), payments: jQuery('#payments').val()},
				  context: document.body
				}).done(function(content) {
					var url = window.location.href; 
					window.location.href = url;					
					},true);
			});	
	}
}

function getParamList(){
	var params = '';
	jQuery("[id^=PAR_]").each(function (){
		params += '&';
		params += jQuery(this).attr('id');
		params += '=';
		params += jQuery(this).attr('value');
	});
	return params;
}

jQuery(function(){
    jQuery('#fileslistdiv').hide();
});

jQuery("input[type=file]").on('change',function(){
    jQuery('#fileslist').html('<span class="files-list-item">'+this.files[0].name+'</span>');
    jQuery('#fileslistdiv').show();
});
</script>



