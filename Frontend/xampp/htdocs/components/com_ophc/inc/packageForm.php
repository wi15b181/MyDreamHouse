<form id="packageForm">
<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');	
?>


<div class="ophc-form">
<?php 
$attributeTypes = getAttributeTypes();
foreach ($attributeTypes as $attr) {
?>

<div class="form-elem">
	<label class="ophc-form-label ">
	<?php echo $attr->attribut_typ_anzeige?>
	</label>
	<?php 
			$selectedValue = null;
			if(isset($_GET['PAR_'.$attr->attribut_typ]) && !empty($_GET['PAR_'.$attr->attribut_typ])){
				echo '<select onchange="loadList();" class="price_calc" id="PAR_'.$attr->attribut_typ.'" name="PAR_'.$attr->attribut_typ.'" value="'.$_GET['PAR_'.$attr->attribut_typ].'" >';
				$selectedValue = $_GET['PAR_'.$attr->attribut_typ];
			}else{
				echo '<select onchange="loadList();" class="price_calc" id="PAR_'.$attr->attribut_typ.'" name="PAR_'.$attr->attribut_typ.'">';
			}?>
			<option value="">Bitte w&auml;hlen... </option>
			<?php 
				$attributes = getAttributeValues($attr);
				foreach ($attributes as $attrVal) {
					if(isset($selectedValue) && !empty($selectedValue) && $selectedValue == $attrVal->wert_id){
						echo '<option selected="selected" value="'.$attrVal->wert_id.'">'.$attrVal->wert_text.'</option>';
					}else{
						echo '<option value="'.$attrVal->wert_id.'">'.$attrVal->wert_text.'</option>';
					}
				}					
			?>
		</select>
</div>
<?php } ?>

<div class="form-elem slider-elem">
	<label class="ophc-form-label ">
		Preis
	</label>
	<input type="hidden" id="PAR_PRICE">
  	<input type="hidden" id="PAR_PRICE_MAX">
  	<input type="text" id="price-span-min" class="slider-input-display" readonly="readonly"><span class="ophc-form-label">&euro;</span>
  	<input type="text" id="price-span-max" class="slider-input-display" readonly="readonly"><span class="ophc-form-label">&euro;</span>
  	<div id="price-slider" class="form-elem-slider"></div>
</div>
  		
<div class="form-elem slider-elem">
	<label class="ophc-form-label ">
		Wohnfl&auml;che:
	</label>
	<input type="hidden" id="PAR_GROUNDAREA">
  	<input type="hidden" id="PAR_GROUNDAREA_MAX">
  	<input type="text" id="ground-span-min" class="slider-input-display" readonly="readonly"><span class="ophc-form-label">m<sup>2</sup></span>
  	<input type="text" id="ground-span-max" class="slider-input-display" readonly="readonly"><span class="ophc-form-label">m<sup>2</sup></span>
  	<div id="ground-slider" class="form-elem-slider"></div>
</div>
<div class="form-elem slider-elem">
	<label class="ophc-form-label ">
		Grundfl&auml;che:
	</label>
	<input type="hidden" id="PAR_LIVINGAREA">
  	<input type="hidden" id="PAR_LIVINGAREA_MAX">
  	<input type="text" id="living-span-min" class="slider-input-display" readonly="readonly"><span class="ophc-form-label">m<sup>2</sup></span>
  	<input type="text" id="living-span-max" class="slider-input-display" readonly="readonly"><span class="ophc-form-label">m<sup>2</sup></span>
  	<div id="living-slider" class="form-elem-slider"></div>
</div>
 <div class="form-elem" id="extra_group" style="height:auto; padding-bottom:10px;">
	<label class="ophc-form-label ">
		Extras
	</label>
	<?php
		$extras = getExtras();
		foreach($extras as $xtra)
		{
		?>
			<div class="checkbox">
				<label><input id="PAR_<?=strtoupper($xtra->attribut_typ)?>" type="checkbox" data-attrid="<?= $xtra->wert_id; ?>"  value="no" class="price_calc price_change"><?=$xtra->attribut_typ_anzeige?></label>
			</div>
		<?php
		}
	?>
</div>
<input type="hidden" id="PAR_PRICEMULT" value="1"/>
<div id="ruleConfig" style="display:none;">
<?php 
	$regeln = getRules();
	echo json_encode($regeln);
?>
</div>

<input type="button" value="Zur&uuml;cksetzen" class="form-btn reset-btn" onclick="resetList();"/>

<div style="clear: both"></div>
</div>

</form>
<script>
var RULES = JSON.parse(jQuery('#ruleConfig').html());
jQuery( document ).ready(function() {	
	jQuery.ajaxSetup({
	    beforeSend:function(){
	        // show gif here, eg:
	        //jQuery("#ajaxLoading").show();
	        //jQuery( '#packageList' ).hide();
	    },
	    complete:function(){
	        // hide gif here, eg:
	        //jQuery("#ajaxLoading").hide();
	        //jQuery('#packageList').show();
	    }
	});
	jQuery('#PAR_AUSBAUSTUFE').addClass('price_change');
	jQuery('.price_calc').change(function() {
		checkRules();
	});
	jQuery( "input[type=checkbox]").change(function() {
		if(this.checked)
			jQuery(this).val('JA');
		else
			jQuery(this).val('NEIN');
	});
	jQuery('.price_change').change(function() {
		calcExtra();
	});
	jQuery( "#price-slider" ).slider({
	    range: true,
	    min: 150000,
	    max: 1000000,
	    <?php 
	    if(isset($_GET['PAR_PRICE']) && !empty($_GET['PAR_PRICE']) && isset($_GET['PAR_PRICE_MAX']) && !empty($_GET['PAR_PRICE_MAX'])){
	    	echo 'values: [ '.$_GET['PAR_PRICE'].', '.$_GET['PAR_PRICE_MAX'].' ],';
	    }else{
	    	echo 'values: [ 250000, 800000 ],';
	    }
	    ?>
	    slide: function( event, ui ) {
	    	jQuery( "#PAR_PRICE" ).val( ui.values[ 0 ] );
	    	jQuery( "#PAR_PRICE_MAX" ).val( ui.values[ 1 ] );
	    	jQuery(	"#price-span-min").val(ui.values[ 0 ]);
	    	jQuery(	"#price-span-max").val(ui.values[ 1 ]);
	    },
	    stop: function( event, ui ) {
	    	loadList();
	    }
	  });
		jQuery( "#PAR_PRICE" ).val( jQuery( "#price-slider" ).slider( "values", 0 ) );
		jQuery( "#PAR_PRICE_MAX" ).val( jQuery( "#price-slider" ).slider( "values", 1 ) );
		jQuery(	"#price-span-min").val(jQuery( "#price-slider" ).slider( "values", 0 ));
		jQuery(	"#price-span-max").val(jQuery( "#price-slider" ).slider( "values", 1 ));
		
	jQuery( "#ground-slider" ).slider({
	    range: true,
	    min: 200,
	    max: 800,
	    <?php 
	    if(isset($_GET['PAR_GROUNDAREA']) && !empty($_GET['PAR_GROUNDAREA']) && isset($_GET['PAR_GROUNDAREA_MAX']) && !empty($_GET['PAR_GROUNDAREA_MAX'])){
	    	echo 'values: [ '.$_GET['PAR_GROUNDAREA'].', '.$_GET['PAR_GROUNDAREA_MAX'].' ],';
	    }else{
	    	echo 'values: [ 300, 700 ],';
	    }
	    ?>
	    slide: function( event, ui ) {
	    	jQuery( "#PAR_GROUNDAREA" ).val( ui.values[ 0 ] );
	    	jQuery( "#PAR_GROUNDAREA_MAX" ).val( ui.values[ 1 ] );
	    	jQuery(	"#ground-span-min").val(ui.values[ 0 ]);
	    	jQuery(	"#ground-span-max").val(ui.values[ 1 ]);
	    },
	    stop: function( event, ui ) {
	    	loadList();
	    }
	  });
		jQuery( "#PAR_GROUNDAREA" ).val( jQuery( "#ground-slider" ).slider( "values", 0 ) );
		jQuery( "#PAR_GROUNDAREA_MAX" ).val( jQuery( "#ground-slider" ).slider( "values", 1 ) );
		jQuery(	"#ground-span-min").val(jQuery( "#ground-slider" ).slider( "values", 0 ));
		jQuery(	"#ground-span-max").val(jQuery( "#ground-slider" ).slider( "values", 1 ));

	jQuery( "#living-slider" ).slider({
	    range: true,
	    min: 50,
	    max: 600,
	    <?php 
	    if(isset($_GET['PAR_LIVINGAREA']) && !empty($_GET['PAR_LIVINGAREA']) && isset($_GET['PAR_LIVINGAREA_MAX']) && !empty($_GET['PAR_LIVINGAREA_MAX'])){
	    	echo 'values: [ '.$_GET['PAR_LIVINGAREA'].', '.$_GET['PAR_LIVINGAREA_MAX'].' ],';
	    }else{
	    	echo 'values: [ 100, 450 ],';
	    }
	    ?>
	    slide: function( event, ui ) {
	    	jQuery( "#PAR_LIVINGAREA" ).val( ui.values[ 0 ] );
	    	jQuery( "#PAR_LIVINGAREA_MAX" ).val( ui.values[ 1 ] );
	    	jQuery(	"#living-span-min").val(ui.values[ 0 ]);
	    	jQuery(	"#living-span-max").val(ui.values[ 1 ]);
	    },
	    stop: function( event, ui ) {
	    	loadList();
	    }
	  });
		jQuery( "#PAR_LIVINGAREA" ).val( jQuery( "#living-slider" ).slider( "values", 0 ) );
		jQuery( "#PAR_LIVINGAREA_MAX" ).val( jQuery( "#living-slider" ).slider( "values", 1 ) );
		jQuery(	"#living-span-min").val(jQuery( "#living-slider" ).slider( "values", 0 ));
		jQuery(	"#living-span-max").val(jQuery( "#living-slider" ).slider( "values", 1 ));
		
	loadList();
})

function resetList(){
	window.location.href='<?php echo $_SERVER['PHP_SELF'];?>';
}

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

// START - - Add by Adnan Jusic related to FST 04; 19.06.2017 //

function calcExtra(){
	
	MULT = 1;
	jQuery('.price_change').each(function() {
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
						jQuery('.price_change').each(function() {
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
	jQuery('#PAR_PRICEMULT').val(MULT);
	var sum = 0;
	jQuery('.base_price').each(function() {
		var base = jQuery(this).val();
		sum = base *MULT;
		jQuery(this).siblings('.calcPrice').html('&euro;'+ (sum).formatMoney(0, ',', '.'));
	});
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

// END - - Add by Adnan Jusic related to FST 04; 19.06.2017 //

function augmentLink(elem){

	var href = jQuery(elem).attr('href');
	href += getParamList();
	jQuery(elem).attr('href',href);
	return false;
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

function loadList(){
	
	var params = '?task=listPackagesAjax&format=raw';

	params += getParamList();
	
	var url = '<?php echo $_SERVER['PHP_SELF'];?>';
	
	url+=params;

	jQuery.ajax({
		  url: url,
		 // context: document.body
		}).done(function(content) {
			jQuery( '#packageList' ).html(content);
			jQuery('.star-container').rating(function(vote, event){
			     // console.log(vote, event);
			},true);
			calcExtra();
		});	
}

function updateValSpan(elem){	
	var elemId = '#';
	elemId += elem.name;
	elemId += "-val";
	jQuery(elemId).html(elem.value);
}


jQuery( function() {

} );

jQuery( function() {

} );

jQuery( function() {
} );
</script>
