<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class jetestimonialViewSettings extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form			= $this->get('Form');
		$this->item			= $this->get('Item');
		$this->state		= $this->get('State');
		$this->script		= $this->get('Script');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();

		parent::display($tpl);

	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', false);

		$canDo 				= jetestimonialHelper::getActions();

		$title				= JText::_('COM_JETESTIMONIAL').' : '.JText::_('COM_JETESTIMONIAL_GLOBALSETTINGS');

		JToolBarHelper::title($title, 'jetestimonial.png');

		if ($canDo->get('core.admin')) {
			JToolBarHelper::apply('settings.apply','JTOOLBAR_APPLY');
		}

		JToolBarHelper::cancel('settings.cancel', 'JTOOLBAR_CLOSE');
		JToolBarHelper::divider();

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_jetestimonial');
			JToolBarHelper::divider();
		}

	//	JToolBarHelper::help('JHELP_ADMIN_USER_PROFILE_EDIT');
	}
}
