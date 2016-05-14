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

jimport('joomla.application.component.controllerform');

class jetestimonialControllerSettings extends JControllerForm
{
	/**
	 * Method to cancel an edit.
	 */
	public function cancel($key = null)
	{
		// Redirect to the main page.
		$this->setRedirect(JRoute::_('index.php?option=com_jetestimonial&view=testimonials', false));
	}
}
?>
