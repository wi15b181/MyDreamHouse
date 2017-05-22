<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
header ( 'Content-Type: text/html; charset=UTF-8' );
?>

<h1>Favoriten</h1>

<div class="appointment-div">	
	<div class="datagrid">
		<table>
			<thead>
				<tr>
					<th>Hauspaket</th>
					<th>Aktionen</th>
				</tr>
			</thead>
			<tbody>
			<?php
	$favoriten = getFavoriten();
	
	$i = 1;
	foreach ( $favoriten as $favorit ) {	
		?>
				<tr <?php if($i%2==0){echo 'class="alt"';}?>>
					<td><a href="<?php echo 'index.php/hauskonfigurator?showDetail='.$favorit->id;?>"><?php echo $favorit->bezeichnung;?></a></td>
					
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