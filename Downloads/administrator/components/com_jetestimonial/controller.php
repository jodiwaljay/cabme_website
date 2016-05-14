<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.controller');

/**
 * Component Controller
 */
class jetestimonialController extends JControllerLegacy
{
	/**
	 * @var		string	The default view.
	 */
	protected $default_view = 'testimonials';

	/**
	 * Method to display a view.
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once(JPATH_COMPONENT.DS.'helpers'.DS.'jetestimonial.php');

		// Load the submenu.
			jetestimonialHelper::addSubmenu(JRequest::getCmd('view', 'testimonials'));

			$view	= JRequest::getCmd('view', 'testimonials');
			$layout = JRequest::getCmd('layout', 'default');
			$id		= JRequest::getInt('id');

		// Check for edit form.
			if ($view == 'testimonial' && $layout == 'edit' && !$this->checkEditId('com_jetestimonial.edit.testimonial', $id)) {

				// Somehow the person just went to the form - we don't allow that.
					$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
					$this->setMessage($this->getError(), 'error');
					$this->setRedirect(JRoute::_('index.php?option=com_jetestimonial&view=testimonials', false));

				return false;
			}

  		parent::display();

		return $this;
	}

	public function previewthemes()
	{
		$themeid		= JRequest::getInt('theme', 1);

		echo JHTML::_('image','administrator/components/com_jetestimonial/assets/images/preview/'.$themeid.'.jpg', JText::_('COM_JETESTIMONIAL_STYLE').$themeid, '', false);
		exit;
	}
}
