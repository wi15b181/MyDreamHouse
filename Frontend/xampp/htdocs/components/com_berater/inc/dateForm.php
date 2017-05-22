<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');	
?>
<script>
<?php
include (JPATH_COMPONENT_SITE . '/inc/js/fullcalendar/moment-with-locales.js');
?>
</script>
<style>
<!--
<?php
include (JPATH_COMPONENT_SITE . '/inc/js/fullcalendar/fullcalendar.min.css');
?>
-->
</style>
<script>
<?php
include (JPATH_COMPONENT_SITE . '/inc/js/fullcalendar/fullcalendar.min.js');
?>
</script>
<script>
<?php
include (JPATH_COMPONENT_SITE . '/inc/js/fullcalendar/locale/de-at.js');
?>
</script>
<div id="calendar">
</div>
<div id="dialog-confirm" title="Neuer Termin" style="display:none;">
	<input type="hidden" id="terminId" />
	<label for="desc">Beschreibung</label>
	<input type="text" name="desc" id="desc" class="text ui-widget-content ui-corner-all">
	<label for="day">Tag</label>
	<input type="text" name="day" class="datepicker" id="date">
	<label for="starttime">Von:</label>
	<select name="starttime" id="starttime">
		<option value="09:00">09:00</option>
		<option value="10:00">10:00</option>
		<option value="11:00">11:00</option>
		<option value="12:00">12:00</option>
		<option value="13:00">13:00</option>
		<option value="14:00">14:00</option>
		<option value="15:00">15:00</option>
		<option value="16:00">16:00</option>
		<option value="17:00">17:00</option>
	</select>
	<label for="endtime">Bis:</label>
	<select name="endtime" id="endtime">
		<option value="10:00">10:00</option>
		<option value="11:00">11:00</option>
		<option value="12:00">12:00</option>
		<option value="13:00">13:00</option>
		<option value="14:00">14:00</option>
		<option value="15:00">15:00</option>
		<option value="16:00">16:00</option>
		<option value="17:00">17:00</option>
		<option value="18:00">18:00</option>
	</select>
</div>
<div id="dialog-delete" title="Termin löschen" style="display:none;">
	<p>Sicher, dass Sie den Termin löschen wollen?</p>
</div>
<div id="dialog-chose" title="Termin Details" style="display:none;">
</div>
<div id="toast-message" title="">
</div>
<?php 
$user = JFactory::getUser();
$joomlaUID = $user->get('id');
unset($user);
$userID = getUserID($joomlaUID);
$beraterID = getBeraterID($userID);
$termine = getTermine($beraterID);
$js_string = "";
foreach($termine as $event)
{
	$js_string .= "{id: '".$event->id."', title: '".$event->description."', start: '".$event->starttime."', end: '".$event->endtime."', description: '', editable: false, hpID: '".$event->hauspaketId."' },";
}
$js_string = trim($js_string, ',');
?>
<input type="hidden" id="userID" value="<?= $userID; ?>" />
<input type="hidden" id="beraterID" value="<?= $beraterID; ?>" />
<input type="hidden" id="hpID" value="" />
<script>
jQuery( document ).ready(function() {	
	jQuery('#toast-message').dialog({
		  autoOpen: false,
	      resizable: false,
	      height: "auto",
	      width: 400,
	      modal: true,
	      buttons: {
	        "Schließen": function() {
			  jQuery( this ).dialog('option', 'title','');
			  jQuery( this ).html('');
	          jQuery( this ).dialog( "close" );
	        }
	      }
	});
	jQuery('#calendar').fullCalendar({
		customButtons: {
	        neuerTermin: {
	            text: 'Neuen Termin!',
	            click: function() {
	               	makeNewTermin();
	            }
	        }
	    },
	    eventClick: function(calEvent) {
	    	eventClicked(this, calEvent);
	    },
		header: {
			left: 'title',
			center: 'neuerTermin',
			right: 'today,month,agendaWeek prev,next'
		},
		weekends: true,
		events: [
				<?= $js_string?>
				],
		views: {
			month: { // name of view
				displayEventEnd : true
			}
		}
	})
});

function eventClicked(elem, calEvent)
{
	showEventDialog(calEvent);
}

function showEventDialog(calEvent)
{
	var desc = calEvent.title;
	var start = new Date(calEvent.start._d);
	var date = new Date(calEvent.start._d);
	start.setHours(start.getHours()-1);
	var end = new Date(calEvent.end._d);
	end.setHours(end.getHours()-1);
	var day = calEvent.start._d.toLocaleDateString();
	var startT = start.toLocaleTimeString().substring(0,5);
	var endT = end.toLocaleTimeString().substring(0,5);
	var html = '<p>Beschreibung: \t\t\t'+desc+'</p>';
	html += '<p>Tag: \t'+day+'</p>';
	html += '<p>Beginn: \t'+startT+'</p>';
	html += '<p>Ende: \t'+endT+'</p>';
	jQuery('#dialog-chose').html(html);
	jQuery('#dialog-chose').dialog({
		 resizable: false,
	     height: "auto",
	     width: 500,
	     modal: true,
	     buttons: {
		     "OPHC Laden": function() {
			     	url = window.location.href.substring(0,window.location.href.indexOf('index.php')+10)+'hauskonfigurator?showDetail='+calEvent.hpID+"&termin="+calEvent.id;
			     	window.location = url;
			 },
			 "Bearbeiten": function() {
		       	jQuery( this ).dialog( "close" );		 
				 makeNewTermin();
				 jQuery('#desc').val(desc);
			   	 jQuery('#dialog-confirm').dialog('option', 'title', 'Termin bearbeiten!');
				 jQuery('#date').datepicker("setDate", date);
				 jQuery('#starttime').val(startT);
				 jQuery('#endtime').val(endT);
				 jQuery('#terminId').val(calEvent.id);
			 },
			 "Löschen": function() {
				jQuery( this ).dialog( "close" );
				delEvent(calEvent);
			 },
	    	 "Abbrechen": function() {
				jQuery( this ).dialog( "close" );
		     }
    	}
	});

	if(calEvent.hpID == null || calEvent.hpID == "")
		jQuery(".ui-dialog-buttonpane button:contains('OPHC')").attr("disabled", true).addClass("ui-state-disabled");
}

function delEvent(calEvent)
{
	jQuery( "#dialog-delete" ).dialog({
	      resizable: false,
	      height: "auto",
	      width: 400,
	      modal: true,
	      buttons: {
	        "Löschen": function() {
	        	var url = '<?php echo $_SERVER['PHP_SELF'];?>';
	        	var userID = jQuery('#userID').val();
	        	var berID = jQuery('#beraterID').val();
		        jQuery.ajax({
		  		  url: url,
		  		  type: 'post',
		  		  data: {
		  			  'task': 'EventAjax',
		  			  'format': 'raw',
		  			  'action': 'delete',
		  			  'id': calEvent.id,
		  			  'ber': berID,
		  			  'user': userID
		  		  }
		  		}).done(function(data) {
			  		if(data == "success")
			  		{
				        jQuery('#calendar').fullCalendar('removeEvents', calEvent.id);
				   		jQuery('#toast-message').dialog('option', 'title', 'Erfolg!');
						jQuery('#toast-message').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin-right:12px;"></span>Termin wurde erfolgreich gelöscht!</p>');
						jQuery('#toast-message').dialog('open');
			  		}
			  		else
			  		{
				   		jQuery('#toast-message').dialog('option', 'title', 'Fehler!');
						jQuery('#toast-message').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin-right:12px;"></span>Fehler beim Löschen!</p>');
						jQuery('#toast-message').dialog('open');
			  		}
		  		});
	        	jQuery( this ).dialog( "close" );
	        },
	        "Abbrechen": function() {
	        	jQuery( this ).dialog( "close" );
	        }
	      }
	    });
}

function makeNewTermin()
{
	jQuery('#desc').val('');
	jQuery('#date').val('');
	jQuery('#starttime').val('09:00');
	jQuery('#endtime').val('10:00');
	jQuery('#terminId').val('');
	jQuery('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
	jQuery( "#dialog-confirm" ).dialog({
	      resizable: false,
	      height: "auto",
	      width: 400,
	      modal: true,
	      buttons: {
	        "Speichern": function() {
		        var desc = jQuery('#desc').val();
		        var day = jQuery('#date').val();
		        var startT = jQuery('#starttime').val();
		        var endT = jQuery('#endtime').val();
		        if(startT >= endT)
		        {
		        	jQuery('#toast-message').dialog('option', 'title', 'Fehler!');
					jQuery('#toast-message').html('<p><span class="ui-icon ui-icon-check" style="float:left; margin-right:12px;"></span>Startzeit muss vor Endzeit sein!</p>');
					jQuery('#toast-message').dialog('open');
			        return;
		        }
		        var startCompl = day + " " +startT;
		        var endCompl = day + " " +endT;
		        var tID = jQuery('#terminId').val();
				var event = {title: desc, start: startCompl, end: endCompl, description: '', editable: false};
			   	saveEvent(tID, desc, startCompl, endCompl,event);
	        	jQuery( this ).dialog( "close" );
	        },
	        "Abbrechen": function() {
	        	jQuery( this ).dialog( "close" );
	        }
	      }
	    });
	   	jQuery('#dialog-confirm').dialog('option', 'title', 'Neuer Termin');
// 	jQuery('#calendar').fullCalendar('addEventSource', [{title: 'My Event',start: '2017-01-01',description: 'This is a cool event', editable: true}] );
}

function saveEvent(id, desc,start,end,event){

	var userID = jQuery('#userID').val();
	var berID = jQuery('#beraterID').val();
	var hpID = jQuery('#hpID').val();
	var url = '<?php echo $_SERVER['PHP_SELF'];?>';
	jQuery.ajax({
		  url: url,
		  type: 'post',
		  data: {
			  'task': 'EventAjax',
			  'format': 'raw',
  			  'action': 'save',
			  'desc': desc,
			  'start': start,
			  'end': end,
			  'ber': berID,
			  'user': userID,
			  'tID': id
		  }
		}).done(function(data) {
			if(!isNaN(parseFloat(data)) && isFinite(data))
			{
				event.id = data;
				if(id != null && id != '')
				{
			        jQuery('#calendar').fullCalendar('removeEvents', id);
					event.id = id;
				}
		   		jQuery('#calendar').fullCalendar('addEventSource', [event] );
		   		jQuery('#toast-message').dialog('option', 'title', 'Erfolg!');
				jQuery('#toast-message').html('<p><span class="ui-icon ui-icon-check" style="float:left; margin-right:12px;"></span>Der Termin wurde gespeichert!</p>');
				jQuery('#toast-message').dialog('open');
			}
			else
			{
				if(data == "CONFLICT")
				{
				   	jQuery('#toast-message').dialog('option', 'title', 'Fehler!');
					jQuery('#toast-message').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin-right:12px;"></span>Überschneidet sich mit einem anderen Termin!</p>');
					jQuery('#toast-message').dialog('open');
				}
				else
				{	
					jQuery('#toast-message').dialog('option', 'title', 'Fehler!');
					jQuery('#toast-message').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin-right:12px;"></span>Fehler beim Speichern</p>');
					jQuery('#toast-message').dialog('open');		
				}
			}
		});
}
</script>

