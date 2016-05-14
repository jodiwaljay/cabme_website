<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
	defined('_JEXEC') or die('Restricted access');

// Create shortcut to parameters.
	$params = $this->state->get('params');

if ($params->get('show_page_heading', 1)) {
?>
	<h1> <?php echo $this->escape($params->get('page_heading')); ?> </h1>
<?php
} elseif($this->item->id == 0 || $this->item->id === '') {
?>
	<h1> <?php echo JText::_('COM_JETESTIMONIAL_FORM_NEW_TESTIMONIAL'); ?> </h1>
<?php
} else {
?>
	<h1> <?php echo JText::_('COM_JETESTIMONIAL_FORM_EDIT_TESTIMONIAL'); ?> </h1>
<?php
}
?>