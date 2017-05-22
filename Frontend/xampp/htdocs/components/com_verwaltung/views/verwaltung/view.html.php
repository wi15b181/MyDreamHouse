<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class VerwaltungViewVerwaltung extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		if(isset($_GET['navigation']) && !empty($_GET['navigation'])){
			$tpl = $_GET['navigation'];
		}		
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}