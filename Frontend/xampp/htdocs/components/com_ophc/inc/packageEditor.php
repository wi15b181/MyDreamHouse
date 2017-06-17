<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.access.access' );

$package = new Package ();
$terminId = null;

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

function isConsultantPhp(){
	$user = JFactory::getUser ();


	$isConsultant = false;

	foreach ( $user->getAuthorisedGroups () as $group ) {
		$isConsultant = $isConsultant || isConsultant ( $group );
	}
	
	return $isConsultant;
	
}

function getReadOnly($customerField){	
	
	$isConsultant = isConsultantPhp();
	$sale;	
	$terminId = $_GET ['termin'];
	
	$saleTemp = getSale($terminId);
	if($saleTemp != null){
		$sale = $saleTemp;
	}
	
	if(isset($sale) && $sale->status == 'PERFECTED'){
		return true;
	}
	
	if($customerField){
		
		if($isConsultant){
			return true;
		}
		
		if(isset($sale) && $sale->status == 'FINALIZED'){
			return false;
		}
		
	}else{
		if($isConsultant){			
			if(isset($sale) && $sale->status != 'DRAFT'){
				return true;
			}else{
				return false;
			}
		}		
	}
	
	return true;
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
			<img style="width: 244px; margin-left: 30px; margin-bottom: 30px;"
				src="<?php
					echo JURI::root () . 'images/ophc/housetypes/' . rand ( 1, 9 );
					?>.jpg">
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
				if(getReadOnly(false)){
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
		if(getReadOnly(false)){		
		?>
		<input disabled="disabled" min="0" max="3" style="width: 30px;" type="number" id="PAR_STOCKWERKE" value="<?php echo $package->stockwerke;?>">
		<?php 
		}else{
		?>		
		<input min="0" max="3" style="width: 30px;" type="number" id="PAR_STOCKWERKE" value="<?php echo $package->stockwerke;?>">
		<?php 
		}?>
		<label class="ophc-form-label ">
			Extras
		</label>
		<?php		
			$extras = getExtras();
			foreach($extras as $xtra)
			{
				$checked = '';
				$val = 'NEIN';
				foreach($package->attributes as $pAttr){
					if($pAttr->attribut_typ == $xtra->attribut_typ && $pAttr->wert_text == 'JA'){
						$checked = 'checked';
						$val = 'JA';
					}
				}
			?>
				<div class="checkbox">
					<label><input data-attrid="<?= $xtra->wert_id; ?>" id="PAR_<?=strtoupper($xtra->attribut_typ)?>" type="checkbox" value="<?= $val ?>" class="price_calc"<?= $checked ?>><?=$xtra->attribut_typ_anzeige?></label>
				</div>
			<?php
			}
		?>
		</div>
		<div class="ophc-detail-right">
				<label class="ophc-form-label ">Anmerkungen (max. 1024 Zeichen)</label>				
				<textarea <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> placeholder="z.B. Kunde besteht auf zertifizierte Subunternehmer" maxlength="1024" id="remarks" style="width: 550px; height: 110px; resize: none;"><?php if(isset($sale)){echo $sale->anmerkungen;}?></textarea>
			
				<label class="ophc-form-label ">Zahlungsvereinbarung (max. 1024 Zeichen)</label>
				<textarea <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?>placeholder="z.B. 3% Rabatt bei Zahlung binnen 21 Tagen." maxlength="1024" id="payments" style="width: 550px; height: 110px; resize: none;"><?php if(isset($sale)){echo $sale->zahlungsvereinbarung;}?></textarea>
				
				<label class="ophc-form-label" for="price">Gesamtpreis: </label>
				<input <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> placeholder="z.B. 400.000,- exkl. USt." value="<?php if(isset($sale)){echo $sale->kaufpreis;}?>" type="text" id="price" value="">
				<p data-baseprice="<?= $package->preis; ?>" id="priceSum"></p>
				<hr/>
				<label class="ophc-form-label" for="price">Kundenr&uuml;ckmeldung: </label>
				<textarea <?php if(getReadOnly(true)){echo ' disabled="disabled" ';}?>placeholder="R&uuml;ckmeldung ausst&auml;ndig..." maxlength="1024" id="message" style="width: 550px; height: 110px; resize: none;"><?php if(isset($sale)){echo $sale->message;}?></textarea>
				
		</div>
	</div>
	<div id="ruleConfig" style="display:none;">
	<?php 
		$regeln = getRules();
		echo json_encode($regeln);
	?>
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
					<form action="" method="post"><input <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> type="hidden" name="delete" value="<?php echo $attachement->attachement_id;?>"/><input style=" <?php if(!isConsultantPhp()){echo 'display: none; ';}?>" type="submit" value="x"></form>
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
				<div style="<?php if(!isConsultantPhp()){echo 'display: none; ';}?>" class="fileUpload form-btn">
					<span>Datei ausw&auml;hlen</span> <input <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> class="upload" type="file"
						name="attachement" id="attachement">
				</div>
				<input style="<?php if(!isConsultantPhp()){echo 'display: none; ';}?>" <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> onclick="save(); return true;" class="form-btn" type="submit" value="Anh&auml;ngen"
					name="submit">
			</form>
		</div>
		</div>
		<hr/>
		
		<div class="ophc-detail-all">
			<div id="menu-div">
				<a href="index.php/berater-termine"><button style="<?php if(!isConsultantPhp()){echo 'display: none; ';}?>float: left;" class="form-btn">Zur&uuml;ck</button></a>
				<a href="index.php/infocenter"><button style="<?php if(isConsultantPhp()){echo 'display: none; ';}?>float: left;" class="form-btn">Zur&uuml;ck</button></a>
				<button  <?php if(getReadOnly(true)){echo ' disabled="disabled" ';}?> style="<?php if(isConsultantPhp() || $sale->status == 'PERFECTED'){echo 'display: none; ';}?>float: right;" onclick="saveMessage()" class="form-btn">R&uuml;ckmelden</button>
				<button  <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> style="<?php if(!isConsultantPhp()){echo 'display: none; ';}?>float: right;" onclick="save()" class="form-btn">Zwischenspeichern</button>
				<button <?php if(getReadOnly(false)){echo ' disabled="disabled" ';}?> style=" <?php if(!isConsultantPhp()){echo 'display: none; ';}?>float: right; margin-right: 20px;" onclick="finish()" class="form-btn finish">Abschluss</button>
			</div>
		</div>
	</div>
</div>

<script>
var RULES = JSON.parse(jQuery('#ruleConfig').html());
var MULT = 1;
jQuery( document ).ready(function() {	
	calcPrice();
	jQuery( "input[type=checkbox]").change(function() {
		if(this.checked)
			jQuery(this).val('JA');
		else
			jQuery(this).val('NEIN');
	});
	jQuery('.price_calc').change(function() {
		checkRules();
		calcPrice();
	});
});


function checkRules() {
	jQuery('select option').removeAttr('disabled');
	jQuery('select').each(function() {
		var id = jQuery(this).val();
		if(id != null)
		{
			jQuery.each(RULES, function( index, rule ) {
				if(rule.regel_erlaubt == true)
					return true; // equals continue
				var block = 0;
				if(rule.regel_attribut_left_id == id)
						block = rule.regel_attribut_right_id;
				else if(rule.regel_attribut_right_id == id)
					block = rule.regel_attribut_left_id;
				
				if(block != 0)
				{
					jQuery('select option[value="'+block+'"]').attr('disabled','disabled');
				}
			});
		}
	});	
}

function calcPrice() {
	MULT = 1;
	jQuery('.price_calc').each(function() {
		var id = jQuery(this).val();
		if(id == 'JA')
		{
			id = jQuery(this).data('attrid');
		}
		if(id != null)
		{
			jQuery.each(RULES, function( index, rule ) {
				if(rule.regel_erlaubt == false)
					return true; // equals continue;
				if(rule.regel_attribut_left_id == id)
				{
					if(rule.regel_attribut_right_id == '' || rule.regel_attribut_right_id == null)
					{
						MULT = MULT * rule.regel_preis_modifikator;
					}
					else
					{
						var found = false;
						var checkId = rule.regel_attribut_right_id;
						jQuery('.price_calc').each(function() {
							var subId = jQuery(this).val();
							if(subId == checkId)
								found = true;
						});
						if(found == true)
							MULT = MULT * rule.regel_preis_modifikator;
					}
				}
			});
		}
	});	
	var sum = jQuery('#priceSum').data('baseprice')*MULT;
	jQuery('#priceSum').html('Kostenkalkulation: '+(sum).formatMoney(0, ',', '.')+' €');
}
Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
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

function saveMessage(){
	jQuery(function(){
		var params = '?task=saveSalesMessage&format=raw';

		params += '&terminId=<?php echo $terminId;?>';
		params += '&status=<?php echo 'PERFECTED';?>';
		
		var url = '<?php echo $_SERVER['PHP_SELF'];?>';
		
		url+=params;

		jQuery.ajax({
			  method: "GET",
			  url: url,
			  data: { message: jQuery('#message').val()},
			  context: document.body
			}).done(function(content) {
				var url = window.location.href; 
				window.location.href = url;					
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



