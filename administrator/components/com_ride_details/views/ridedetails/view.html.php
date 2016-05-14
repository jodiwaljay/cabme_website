<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Ride_details
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Ride_details.
 *
 * @since  1.6
 */
class Ride_detailsViewRidedetails extends JViewLegacy
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

		Ride_detailsHelpersRide_details::addSubmenu('ridedetails');

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
		$state = $this->get('State');
		$canDo = Ride_detailsHelpersRide_details::getActions();

		JToolBarHelper::title(JText::_('COM_RIDE_DETAILS_TITLE_RIDEDETAILS'), 'ridedetails.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/ridedetail';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('ridedetail.add', 'JTOOLBAR_NEW');
				JToolbarHelper::custom('ridedetails.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('ridedetail.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('ridedetails.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('ridedetails.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'ridedetails.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('ridedetails.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('ridedetails.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'ridedetails.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('ridedetails.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_ride_details');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_ride_details&view=ridedetails');

		$this->extra_sidebar = '';
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

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
			'a.`userimg`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_USERIMG'),
			'a.`name`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_NAME'),
			'a.`rides`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_RIDES'),
			'a.`rating`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_RATING'),
			'a.`srcaddress`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_SRCADDRESS'),
			'a.`dstaddress`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_DSTADDRESS'),
			'a.`pickuppoint`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_PICKUPPOINT'),
			'a.`cartype`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_CARTYPE'),
			'a.`verified`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_VERIFIED'),
			'a.`price`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_PRICE'),
			'a.`seats`' => JText::_('COM_RIDE_DETAILS_RIDEDETAILS_SEATS'),
		);
	}
}
