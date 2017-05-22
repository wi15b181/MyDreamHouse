<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * OPHC Component Controller
 */
class OphcController extends JControllerLegacy
{
	function listPackagesAjax()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/listPackages.php');
	}
	
	function saveRatingAjax()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/rate.php');
	}
	
	function getOpenDates()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/openDates.php');
	}
	
	function saveAppointment()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/saveAppointment.php');
	}
	
	function generateData(){
		include(JPATH_COMPONENT_SITE.'/inc/randomDataGen.php');		
	}
	
	function saveCustomerPackage()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/saveCustomerPackage.php');
	}
	
	function saveSale()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/saveSale.php');
	}
	
	function saveSalesMessage()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/saveSalesMessage.php');
	}
	
	function saveFavorite()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/fav.php');
	}
}