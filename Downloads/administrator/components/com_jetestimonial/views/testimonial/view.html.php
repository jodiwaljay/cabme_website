<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die( 'Restricted Access' );

jimport('joomla.application.component.view');

class jetestimonialViewTestimonial extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	function display( $tpl = null )
	{
		// Initialiase variables.
			$this->form			= $this->get('Form');
			$this->item			= $this->get('Item');
			$this->state		= $this->get('State');
			$this->script		= $this->get('Script');

		// Check for errors.
			if (count($errors	= $this->get('Errors'))) {
				JError::raiseError(500, implode("\n", $errors));
				return false;
	}

			$this->addToolbar();

		parent::display( $tpl );

		// Set the document
		$this->setDocument();
}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', false);

		$user					= JFactory::getUser();
		$userId					= $user->get('id');
		$isNew					= ($this->item->id == 0);
		$canDo					= jetestimonialHelper::getActions($this->state->get('filter.category_id'));

		$text					= $isNew ? JText::_('COM_JETESTIMONIAL_TESTIMONIAL_NEW') : JText::_('COM_JETESTIMONIAL_TESTIMONIAL_EDIT');

		$title					= JText::_('COM_JETESTIMONIAL').' : '.JText::_('COM_JETESTIMONIAL_MANAGE_TESTIMONIAL')." : <em>[".$text."]</em>";

		JToolBarHelper::title($title, 'jetestimonial.png');

		if ($isNew) {
			// For new records, check the create permission.
				if ($canDo->get('core.create')) {
				JToolBarHelper::apply('testimonial.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('testimonial.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('testimonial.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::divider();
			JToolBarHelper::cancel('testimonial.cancel', 'JTOOLBAR_CANCEL');
		} else {
			if ($canDo->get('core.edit')) {
				// We can save the new record
				JToolBarHelper::apply('testimonial.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('testimonial.save', 'JTOOLBAR_SAVE');

				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create')) {
					JToolBarHelper::custom('testimonial.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}

			if ($canDo->get('core.create')) {
				JToolBarHelper::custom('testimonial.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}

			JToolBarHelper::divider();
			JToolBarHelper::cancel('testimonial.cancel', 'JTOOLBAR_CLOSE');
		}

		//JToolBarHelper::divider();
		//JToolBarHelper::help('JHELP_COMPONENTS_CONTACTS_CONTACTS_EDIT');
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew			= ($this->item->id == 0);
		$document		= JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_JETESTIMONIAL_TESTIMONIAL_NEW') : JText::_('COM_JETESTIMONIAL_TESTIMONIAL_EDIT'));

		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "/administrator/components/com_jetestimonial/assets/js/submitbutton.js");
	}
}
?>