<?php
// No direct access to this file
include (JPATH_COMPONENT_SITE . '/inc/header.php');
include (JPATH_COMPONENT_SITE . '/inc/dbutil.php');
?>

<script>
<?php
include (JPATH_COMPONENT_SITE . '/inc/js/rating.js');
?>
</script>

<style>
<!--
<?php

include (JPATH_COMPONENT_SITE . '/inc/css/ophc.css');


include (JPATH_COMPONENT_SITE . '/inc/css/rating.css');

?>
#d4d5d6-->
</style>

<?php

if (isset ( $_GET ['showDetail'] ) && ! empty ( $_GET ['showDetail'] )) {
	$package = getPackage ( $_GET ['showDetail'] );
	?>

<div class="package-detail">
	<div class="package-detail-header">
		<span class="package-title"><?php echo $package->bezeichnung;?></span>
	</div>
	<div class="package-detail-content">
		<div class="package-image">
			<img style="width: 244px; height: 163px;"
				src="<?php
	echo JURI::root () . 'images/ophc/housetypes/' . rand ( 1, 9 );
	?>.jpg">
		</div>
		<div class="package-detail-data-header">
		<div class="package-detail-data-header-element">
		</div>
		<div class="package-detail-data-header-element">
		</div>
		<div style="text-align: right; font-size: 2em; padding-top: 9px;" class="package-detail-data-header-element elem-price">
		<span ><?php 
							echo ' &euro; '.number_format($package->preis,0,',','.').' <small>(UVB)</small>';
							?></span>
		</div>
		</div>
		<div class="datagrid">
			<table>
				<tbody>
				<?php 
				$num = 1;
				foreach($package->attributes as $attr){
					?>
					
					<tr <?php  if($num%2==1){echo 'class="alt"';}?>>
						<td style="font-weight: bold;"><?php echo $attr->attribut_typ_anzeige;
						?>						
						</td>
						<td><?php 

						if($attr->attribut_typ == 'ENERGIEWERT'){
							echo '<img style="height: 20px;" src="'.JURI::root().'images/ophc/'.$attr->wert_ordnung.'.jpg"/>';
						}else{
							echo $attr->wert_text;
						}
						?></td>
					</tr>
					
					<?php 		
					$num++;
				}
				?>
				</tbody>
			</table>
		</div>
		<div class="package-detail-body">
		<h1>Ihr neues Traumhaus ?</h1>
		<p style="text-align: justify;">
		"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
		</p>
		
		<div class="berater-div">
		
		<?php 
			$berater = getConsultantForPackage($package->id);
			
			$beraterRating = getRatingForBerater($berater->berater_id);
			
			?>			
		<div class="detail-berater-star-div">
			<div class="berater-star-container">
						    <input type="radio" name="ber" <?php if($beraterRating == 1)echo 'checked="checked"'?> class="rating" value="1" />
						    <input type="radio" name="ber" <?php if($beraterRating == 2)echo 'checked="checked"'?> class="rating" value="2" />
						    <input type="radio" name="ber" <?php if($beraterRating == 3)echo 'checked="checked"'?> class="rating" value="3" />
						    <input type="radio" name="ber" <?php if($beraterRating == 4)echo 'checked="checked"'?> class="rating" value="4" />
						    <input type="radio" name="ber" <?php if($beraterRating == 5)echo 'checked="checked"'?> class="rating" value="5" />
			</div>
		</div>
		
		<h1>Ihr Berater: </h1>
		<img width="144" src="<?php
			echo JURI::root () . 'images/ophc/berater/'.$berater->bild;
			?>">
			<p>
				<b> <?php echo $berater->name;?></b>
			</p>
			</div>
		</div>
		<div>
		
		
		
		<div class="detail-star-div">
		Durchschnittliche Kundenbewertung f&uuml;r dieses Paket: 
			<div class="star-container detail-star">
						    <input type="radio" name="bewpak" <?php if($package->rating == 1)echo 'checked="checked"'?> class="rating" value="1" />
						    <input type="radio" name="bewpak" <?php if($package->rating == 2)echo 'checked="checked"'?> class="rating" value="2" />
						    <input type="radio" name="bewpak" <?php if($package->rating == 3)echo 'checked="checked"'?> class="rating" value="3" />
						    <input type="radio" name="bewpak" <?php if($package->rating == 4)echo 'checked="checked"'?> class="rating" value="4" />
						    <input type="radio" name="bewpak" <?php if($package->rating == 5)echo 'checked="checked"'?> class="rating" value="5" />
			</div>
						(<?php echo getCountRating($package->id);?> Bewertungen)
		</div>
		
		<div id="appointment-dialog" title="Basic dialog" style="display: none;">
			<form id="dialog-form">
		 	<div class="ophc-dialogue-form">
		 		<h2>W&auml;hlen Sie einen freien Termin:</h2>
		 		<h3><label for="datum-select">Datum: </label></h3>
		 		<input id="datum-select">
		 		<h3><label for="uhrzeit-select">M&ouml;gliche Uhrzeiten: </label></h3>
		 		<select disabled="disabled" id="uhrzeit-select"></select>		 	
		 	</div>
		 	</form>
		</div>
		</div>
	</div>
</div>
<div style=" float: left;">						
		<?php echo '<a href="'.$_SERVER['PHP_SELF'].getReverseFormParams().'"><button class="form-btn">Zur&uuml;ck</button></a>';?>
</div>
<div style="margin-right: -12px;">						
		<input id="appointment-button" type="button" class="form-btn" style="float: right;" onclick="return false;" value="Termin vereinbaren">
</div>
<script type="text/javascript">
	jQuery( function() {
		
	    var appDialog = jQuery( "#appointment-dialog" );


	    jQuery( "#datum-select" ).datepicker({
		    beforeShowDay: noWeekendsOrHolidays,
		    dateFormat: 'dd.mm.yy',
		    onSelect: function(dateText) {
		        var params = '?task=getOpenDates&format=raw';

				
				var url = '<?php echo $_SERVER['PHP_SELF'];?>';

				url+=params;
				url+='<?php echo '&beraterId=2&date=';?>'+dateText;
			
	 			jQuery.ajax({
	 				  url: url,
					  context: document.body
					}).done(function(content) {
						jQuery('#uhrzeit-select').html(content);
						jQuery('#uhrzeit-select').prop('disabled', false);
					});
		    }
		    });
	    
	    function noWeekendsOrHolidays(date) {
	        return jQuery.datepicker.noWeekends(date);
	    }
		
		jQuery( "#appointment-button" ).button().on( "click", function() {
			appDialog.dialog({
				 open: function () {
			         jQuery('#dialog-form')[0].reset();
					 jQuery('#uhrzeit-select').html("");
						jQuery('#uhrzeit-select').prop('disabled', true);
					 jQuery(this).parents(".ui-dialog:first").find("button").addClass("form-btn");
					 jQuery(this).siblings('.ui-dialog-titlebar').remove();
                 },
			      autoOpen: true,
			      width: 'auto', // overcomes width:'auto' and maxWidth bug
			      maxWidth: 400,
			      height: 'auto',
			      modal: true,
			      resizable: false,
			      buttons: {
			        "Absenden": function() {					
				        
						var url = '<?php echo $_SERVER['PHP_SELF'];?>';
						
			        	var params = '?task=saveAppointment&format=raw';	
						url+=params;
						
						url+='&packageId=<?php echo $package->id;?>&day='+jQuery('#datum-select').val()+'&time='+jQuery('#uhrzeit-select').val();
	
 			 			jQuery.ajax({
 			 				  url: url,
 							  context: document.body
 							}).done(function(content) {
 								alert(content);
 							});
			        	appDialog.dialog( "close" );
			        },
			        Abbrechen: function() {
			        	appDialog.dialog( "close" );
			        }
			      },
			      close: function() {
			      }
			    });
		    });



		jQuery('.berater-star-container').rating(function(vote, event){
			var params = '?task=saveRatingAjax&format=raw';
						
			var url = '<?php echo $_SERVER['PHP_SELF'];?>';

			url+=params;
			url+='<?php echo '&type=CONSULTANT&refId='.$berater->berater_id.'&rating=';?>'+vote;

		
 			jQuery.ajax({
 				  url: url,
				  context: document.body
				}).done(function(content) {
					alert("Vielen Dank!");
					jQuery('.detail-berater-star-div').hide();
			});
			},
			false
		);
		

		jQuery('.star-container').rating(function(vote, event){
			var params = '?task=saveRatingAjax&format=raw';

			
			var url = '<?php echo $_SERVER['PHP_SELF'];?>';

			url+=params;
			url+='<?php echo '&type=PACKAGE&refId='.$package->id.'&rating=';?>'+vote;

		
 			jQuery.ajax({
 				  url: url,
				  context: document.body
				}).done(function(content) {
					alert("Vielen Dank!");
					jQuery('.detail-star-div').hide();
		});
		},
		false
		);
	} );
</script>
<?php
} else {
	die ();
}
function getReverseFormParams(){
	$params = '?indiferrent';
	foreach ($_GET as $key => $value){
		if(substr($key,0,4) === 'PAR_'){
			$params = $params.'&'.$key.'='.$value;
		}
	}
	return $params;
}



?>