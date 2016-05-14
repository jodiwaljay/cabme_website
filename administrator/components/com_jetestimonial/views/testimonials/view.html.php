<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die( 'Restricted Access' );

//jimport('joomla.application.component.view');

class jetestimonialViewTestimonials extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	function display( $tpl = null )
	{
			$this->items		= $this->get('Items');
			$this->pagination	= $this->get('Pagination');
			$this->state		= $this->get('State');
			$this->user			= JFactory::getUser();

			// Check for errors.
				if (count($errors = $this->get('Errors'))) {
					JError::raiseError(500, implode("\n", $errors));
					return false;
				}

			// Preprocess the list of items to find ordering divisions.
			// TODO: Complete the ordering stuff with nested sets
				foreach ($this->items as &$item) {
					$item->order_up = true;
					$item->order_dn = true;
	}

	$this->addToolbar();

	parent::display( $tpl );
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		// Initialize variables
			$canDo		= jetestimonialHelper::getActions($this->state->get('filter.category_id'));


			JToolBarHelper::title( JText::_('COM_JETESTIMONIAL').' : '.JText::_('COM_JETESTIMONIAL_MANAGE_TESTIMONIALS'), 'jetestimonial.png');

			if ($canDo->get('core.create')) {
				JToolBarHelper::addNew('testimonial.add','JTOOLBAR_NEW');
			}

			if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
				JToolBarHelper::editList('testimonial.edit','JTOOLBAR_EDIT');
			}

			if ($canDo->get('core.edit.state')) {
				JToolBarHelper::divider();
				JToolBarHelper::custom('testimonials.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('testimonials.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('testimonials.archive','JTOOLBAR_ARCHIVE');
			}

			/*if ($canDo->get('core.delete')) {
				JToolBarHelper::deleteList('', 'faqs.delete', 'JTOOLBAR_DELETE');
			}*/

			if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
				JToolBarHelper::deleteList('', 'testimonials.delete','JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			} else if ($canDo->get('core.edit.state')) {
				JToolBarHelper::trash('testimonials.trash','JTOOLBAR_TRASH');
			}

			if ($canDo->get('core.admin')) {
				JToolBarHelper::divider();
				JToolBarHelper::preferences('com_jetestimonial');
			}

		//	JToolBarHelper::divider();
		//	JToolBarHelper::help('JHELP_COMPONENTS_CONTACTS_CONTACTS');
	}
	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'tm.state' => JText::_('JSTATUS'),
			'tm.title' => JText::_('JGLOBAL_TITLE'),
			'tm.access' => JText::_('JGRID_HEADING_ACCESS'),
			'tm.language' => JText::_('JGRID_HEADING_LANGUAGE'),
			'tm.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
?>