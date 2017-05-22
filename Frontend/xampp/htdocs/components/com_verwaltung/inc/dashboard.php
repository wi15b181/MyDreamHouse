<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
header('Content-Type: text/html; charset=UTF-8');
?>
<div style="margin-top: 30px;">
	<div id="appoint" class="package-detail">
		<div class="package-detail-header">
			<span class="package-title">Meine Termine</span>
		</div>
		<div class="package-detail-content">
			<div class="tile-image">
				<img
					src="<?php
		echo JURI::root () . 'images/ophc/app.png'?>">
			</div>
		</div>
	</div>
	<div id="fav" class="package-detail">
		<div class="package-detail-header">
			<span class="package-title">Meine Favoriten</span>
		</div>
		<div class="package-detail-content">
			<div class="tile-image">
				<img
					src="<?php
		echo JURI::root () . 'images/ophc/fav.png'?>">
			</div>
	
		</div>
	</div>
	<div id="contr" class="package-detail">
		<div class="package-detail-header">
			<span class="package-title">Meine Kaufangebote</span>
		</div>
		<div class="package-detail-content">
			<div class="tile-image">
				<img 
					src="<?php
		echo JURI::root () . 'images/ophc/contr.png'?>">
			</div>
	
		</div>
	</div>
</div>

<script>
jQuery(".package-detail").click(function() {
	 var url = '<?php echo $_SERVER['PHP_SELF'];?>';
	 url+='?navigation='+jQuery(this).attr("id");
	 window.location = url;
	 return false;
});
</script>