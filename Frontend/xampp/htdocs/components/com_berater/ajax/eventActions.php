<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>
<?php 
$allowedActions = array('save', 'delete');
if(!isset($_POST['action'])|| !in_array($_POST['action'], $allowedActions))
{
	header('HTTP/1.0 403 Forbidden');
	die();
}
ob_start();
switch($_POST['action'])
{
	case 'save': TermSave();
		break;
	case 'delete': TermDelete();
		break;
}
ob_end_flush();

function TermSave()
{
	$available = checkTime($_POST['ber'], $_POST['start'], $_POST['end'], $_POST['tID']);
	if(!$available)
	{
		echo "CONFLICT";
		return;
	}
	if($_POST['hpID'] == null)
		$_POST['hpID'] = 'NULL';
	if($_POST['tID'] == null)
		$result = saveTermin($_POST['user'], $_POST['hpID'], $_POST['ber'], $_POST['desc'], $_POST['start'], $_POST['end']);
	else
		$result = updateTermin($_POST['user'], $_POST['hpID'], $_POST['ber'], $_POST['desc'], $_POST['start'], $_POST['end'], $_POST['tID']);
	ob_clean();
	if($result === false)
	{
		echo "FEHLER!";
	}
	else
		echo $result;
}

function TermDelete()
{
	$result = deleteTermin($_POST['user'], $_POST['ber'], $_POST['id']);
	ob_clean();
	if($result === false)
	{
		echo "FEHLER!";
	}
	else
		echo "success";
}
?>