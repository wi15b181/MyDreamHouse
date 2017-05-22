<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
header ( 'Content-Type: text/html; charset=UTF-8' );
?>

<h1>Termine</h1>
<div class="appointment-div">	
	<div class="datagrid">
		<table>
			<thead>
				<tr>
					<th>Hauspaket</th>
					<th>Datum</th>
					<th>Von</th>
					<th>Bis</th>
					<th>Berater</th>
					<th>Aktionen</th>
				</tr>
			</thead>
			<tbody>
			<?php
	$appointments = getAppointments ();
	
	$i = 1;
	foreach ( $appointments as $appointment ) {	
		?>
				<tr <?php if($i%2==0){echo 'class="alt"';}?>>
					<td><a href="<?php echo 'index.php/hauskonfigurator?showDetail='.$appointment->id;?>"><?php echo $appointment->bezeichnung;?></a></td>
					<td><?php echo $appointment->tag;?></td>
					<td><?php echo $appointment->von;?></td>
					<td><?php echo $appointment->bis;?> Uhr</td>
					<td><?php echo $appointment->name;?></td>
					<td>X</td>
				</tr>
		<?php 
		$i++;
	}
	
	?>
	</tbody></table>	
	</div>	
</div>
<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="form-btn">zur&uuml;ck</a>