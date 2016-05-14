<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Driver_details
 * @author     Tabrez ulla khan <tabrez@redwebdesign.in>
 * @copyright  Copyright (C) 2016. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Driver_details.
 *
 * @since  1.6
 */
class Driver_detailsViewDriverdetails extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		Driver_detailsHelper::addSubmenu('driverdetails');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/driver_details.php';

		$state = $this->get('State');
		$canDo = Driver_detailsHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_DRIVER_DETAILS_TITLE_DRIVERDETAILS'), 'driverdetails.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/driverdetail';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('driverdetail.add', 'JTOOLBAR_NEW');
				JToolbarHelper::custom('driverdetails.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('driverdetail.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('driverdetails.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('driverdetails.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'driverdetails.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('driverdetails.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('driverdetails.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'driverdetails.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('driverdetails.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_driver_details');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_driver_details&view=driverdetails');

		$this->extra_sidebar = '';
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);
		//Filter for the field dgen
		$select_label = JText::sprintf('COM_DRIVER_DETAILS_FILTER_SELECT_LABEL', 'Gender');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "Male";
		$options[1] = new stdClass();
		$options[1]->value = "2";
		$options[1]->text = "Female";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_dgen',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.dgen'), true)
		);

	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
			'a.`state`' => JText::_('JSTATUS'),
			'a.`duid`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_DUID'),
			'a.`dname`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_DNAME'),
			'a.`demail`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_DEMAIL'),
			'a.`dmobile`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_DMOBILE'),
			'a.`dgen`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_DGEN'),
			'a.`cab_no`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_CAB_NO'),
			'a.`cab_type`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_CAB_TYPE'),
			'a.`price_per_km`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_PRICE_PER_KM'),
			'a.`license_no`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_LICENSE_NO'),
			'a.`route_prefer`' => JText::_('COM_DRIVER_DETAILS_DRIVERDETAILS_ROUTE_PREFER'),
		);
	}
}
