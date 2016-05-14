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

// Import Joomla predefined functions
	jimport('joomla.application.component.modelitem');

	jimport('joomla.filesystem.folder');

class jetestimonialModelTestimonials extends JModelItem
{
	/**
	 * total Testimonials
	 */
	var $_total									= null;

	/**
	 * Pagination object
	 */
	var $_pagination							= null;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		//Get configuration
			$app								= JFactory::getApplication();
			$config								= JFactory::getConfig();

		// Get the pagination request variables
			$this->setState('limit', $app->getUserStateFromRequest('com_jetestimonial.limit', 'limit', $config->get('list_limit'), 'int'));
			$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$settings								= $this->getSettings();
		$order_by								= $settings->orderby;
		$sort_by								= $settings->sortby;

		if($order_by==='random'){
			$order				= 'rand()';
			}else{
			$order				= 'tm .'.$order_by;
			}
		$this->setState('list.ordering', $order);

		$this->setState('list.direction', $sort_by);
	}

	/**
	 * Method to get Testimonials data.
	 */
	public function getItems()
	{
		// Connect db
			$db									= $this->getDbo();
			$query								= $db->getQuery(true);
			$id									= JRequest::getInt('id');
			$settings							= $this->getSettings();
			
		$query->select('tm.*');
		$query->from('#__jetestimonial_testimonials AS tm');
		/*Readmore click Jemodule testimonial start*/
		if($id!='')
		$query->where('id='.$id);
		/*Readmore click Jemodule testimonial end*/
		$db->setQuery($query);
		$faq									= $db->loadObjectList();

		if ($error = $db->getErrorMsg()) {
			throw new Exception($error);
		}

		if( empty($faq) ) {
			JError::raiseNotice(404, JText::_('COM_JETESTIMONIAL_ERROR_TESTIMONIALS_NOT_FOUND'));
		} else {

				$query->where('tm.published = 1');
				$query->order($db->escape($this->getState('list.ordering', 'tm.ordering')).' '.$db->escape($this->getState('list.direction', 'desc')));			
			
			$faqs								= $db->loadObjectList();

			if( empty( $faqs )) {
				JError::raiseNotice(404, JText::_('COM_JETESTIMONIAL_ERROR_TESTIMONIALS_NOT_PUBLISHED'));
			}

			/*pagination backend settings*/
			$settings								= $this->getSettings();
			$show_pagination_jextn					= $settings->show_pagination_jextn;
			$pagination_limit						= $settings->pagination_limit;
			$pagination_limit_increase				= $pagination_limit+1;
			$this->_total							= count($faqs);

			if($show_pagination_jextn){
			if($pagination_limit < $pagination_limit_increase){
				$this->_data					= array_splice($faqs, $this->getState('limitstart'),  $pagination_limit);
			}
			} else {
				$this->_data					= $faqs;
			}


			return $this->_data;
		}
	}

	/**
	 * Method to get the total number of weblink items for the category
	 */
	function getTotal()
	{
		return $this->_total;
	}

	/**
	 * Method to get a pagination object of the weblink items for the category
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
			if (empty($this->_pagination))
			{
				$settings								= $this->getSettings();
				$show_pagination_jextn					= $settings->show_pagination_jextn;
				$pagination_limit						= $settings->pagination_limit;
				$pagination_limit_increase				= $pagination_limit+1;	

				jimport('joomla.html.pagination');
				if($show_pagination_jextn){
					if($pagination_limit < $pagination_limit_increase){
					$this->_pagination				= new JPagination($this->getTotal(), $this->getState('limitstart'), $pagination_limit);
					}
				}
			}

		return $this->_pagination;
	}

	public function getSettings()
	{
		$id					= 1;
		$settings  			= JTable::getInstance('Settings', 'jetestimonialTable');
		$settings->load($id);

		return $settings;
	}
	public function getVideo()
	{
		$id = JRequest::getInt('id');

		$db	= $this->getDbo();
		$query								= $db->getQuery(true);

		$query->select('tm.*');

		$query->from('#__jetestimonial_testimonials AS tm ');

		$query->where('id='.$id);

		 $db->setQuery($query);

		$video = $db->loadObject();

		return $video;
	}

	public function activateTestimonial(){

		$id			= JRequest::getInt('tid');
		$table  	= JTable::getInstance('Testimonial', 'jetestimonialTable');

		$table->load($id);
		$table->published = '1';

		if (!$table->store()) {
			return false;
		} else {
			return true;
		}
	}
}
?>
