<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
header ( 'Content-Type: text/html; charset=UTF-8' );
?>

<h1>Verkaufsangebote</h1>

<div class="appointment-div">	
	<div class="datagrid">
		<table>
			<thead>
				<tr>
					<th>Hauspaket</th>
				</tr>
			</thead>
			<tbody>
			<?php
	$contracts = getContracts();
	
	$i = 1;
	foreach ( $contracts as $contract ) {	
		?>
				<tr <?php if($i%2==0){echo 'class="alt"';}?>>
					<td><a href="<?php echo 'index.php/hauskonfigurator?termin='.$contract->termin_id.'&showDetail='.$contract->id;?>"><?php echo $contract->bezeichnung;?></a></td>
				</tr>
		<?php 
		$i++;
	}
	
	?>
	</tbody></table>	
	</div>	
</div>
<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="form-btn">zur&uuml;ck</a>