<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');
$tparams = $this->params;
jimport('joomla.html.html.bootstrap');
?>

<div class="contact<?php echo $this->pageclass_sfx?>" itemscope itemtype="https://schema.org/Person">
	

		<?php echo $this->loadTemplate('form'); ?>

	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
