<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Berater Component Controller
 */
class BeraterController extends JControllerLegacy
{
	function EventAjax()
	{
		include(JPATH_COMPONENT_SITE.'/ajax/eventActions.php');
	}
}