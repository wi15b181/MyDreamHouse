<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the OPHC Component
 */
class OphcViewOphc extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		if(isset($_GET['showDetail']) && !empty($_GET['showDetail'])){
			$tpl = 'detail';
		}
		
		if(isset($_GET['termin'])){
			$tpl = 'ophc';			
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