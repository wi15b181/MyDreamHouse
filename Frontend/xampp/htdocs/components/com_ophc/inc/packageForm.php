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
				echo '<select onchange="loadList();" id="PAR_'.$attr->attribut_typ.'" name="PAR_'.$attr->attribut_typ.'" value="'.$_GET['PAR_'.$attr->attribut_typ].'" >';
				$selectedValue = $_GET['PAR_'.$attr->attribut_typ];
			}else{
				echo '<select onchange="loadList();" id="PAR_'.$attr->attribut_typ.'" name="PAR_'.$attr->attribut_typ.'">';
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

<div class="form-elem" style="width: 200px;">
</div>

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
				<label><input id="PAR_<?=strtoupper($xtra->attribut_typ)?>" type="checkbox" value="no"><?=$xtra->attribut_typ_anzeige?></label>
			</div>
		<?php
		}
	?>
</div>

<input type="button" value="Zur&uuml;cksetzen" class="form-btn reset-btn" onclick="resetList();"/>

<div style="clear: both"></div>
</div>

</form>
<script>
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

	jQuery( "#extra_group input[type=checkbox]").change(function() {
		if(this.checked)
			jQuery(this).val('yes');
		else
			jQuery(this).val('no');
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
		  context: document.body
		}).done(function(content) {
			jQuery( '#packageList' ).html(content);
			jQuery('.star-container').rating(function(vote, event){
			    // console.log(vote, event);
			},true);
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
