<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Retricted Access');

jimport('joomla.application.component.model');

/**
 * This models supports retrieving lists of JE Testimonial categories.
 */
class jetestimonialModelCategories extends JModelLegacy
{
	/**
	 * Model context string.
	 */
	public $_context				= 'com_jetestimonial.categories';

	/**
	 * The category context (allows other extensions to derived from this model).
	 */
	protected $_extension			= 'com_jetestimonial';

	private $_parent				= null;

	private $_items					= null;

	function __construct()
	{
		parent::__construct();

		//Get configuration
			$app		= JFactory::getApplication();
			$config		= JFactory::getConfig();

		// Get the pagination request variables
			$this->setState('limit', $app->getUserStateFromRequest('com_jetestimonial.limit', 'limit', $config->get('list_limit'), 'int'));
			$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	function getTotal()
	{
		return $this->_total;
	}


	function getPagination()
	{
		// Lets load the content if it doesn't already exist
			$settings					= $this->getSettings();
			$show_pagination_jextn		= $settings->show_pagination_jextn;
			$pagination_limit			= $settings->pagination_limit;
			$pagination_limit_increase	= $pagination_limit+1;
			if ($show_pagination_jextn)
			{
				if($pagination_limit < $pagination_limit_increase){
				jimport('joomla.html.pagination');

					$this->_pagination				= new JPagination($this->getTotal(), $this->getState('limitstart'), $pagination_limit);
				}
			}else{
			
					$this->_pagination				= new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
			
			}

		return $this->_pagination;
	}	
	
	/*function getPagination()
	{
		// Lets load the content if it doesn't already exist
			$settings					= $this->getSettings();
			$show_pagination_jextn		= $settings->show_pagination_jextn;
			$pagination_limit			= $settings->pagination_limit;
			$pagination_limit_increase	= $pagination_limit+1;
			if (empty($this->_pagination))
			{
				jimport('joomla.html.pagination');
					$this->_pagination				= new JPagination($this->getTotal(), $this->getState('limitstart'), $pagination_limit);
			}

		return $this->_pagination;
	}*/


	/**
	 * Method to auto-populate the model state.
	 */
	protected function populateState()
	{
		$app						= JFactory::getApplication();
		$this->setState('filter.extension', $this->_extension);

		// Get the parent id if defined.
			$parentId				= JRequest::getInt('id');
			$this->setState('filter.parentId', $parentId);

		$params						= $app->getParams();
		$this->setState('params', $params);

		$this->setState('filter.published',	1);
		$this->setState('filter.access',	true);
	}

	/**
	 * redefine the function an add some properties to make the styling more easy
	 */
	public function getItems()
	{
		if(!count($this->_items))
		{
			$app					= JFactory::getApplication();
			$menu					= $app->getMenu();
			$active					= $menu->getActive();
			$params					= new JRegistry();
			$settings				= $this->getSettings();
			$show_pagination_jextn	= $settings->show_pagination_jextn;
			$pagination_limit		= $settings->pagination_limit;
			$pagination_limit_increase	= $pagination_limit+1;

			if($active)	{
				$params->loadString($active->params);
			}

			$options				= array();
			$options['countItems']	= $params->get('show_cat_items_cat', 1) || !$params->get('show_empty_categories_cat', 0);

			$categories				= JCategories::getInstance('jetestimonial', $options);
			$this->_parent			= $categories->get($this->getState('filter.parentId', 'root'));

			if(is_object($this->_parent)) {
				$this->_items		= $this->_parent->getChildren();
				$this->_total	= count($this->_items);
			} else {
				$this->_items		= false;
			}
			/*Jextn pagination*/
			/*Jextn pagination*/
			if($show_pagination_jextn){
			if($pagination_limit < $pagination_limit_increase){
				$this->_data	= array_splice($this->_items, $this->getState('limitstart'), $pagination_limit);
			}
			}else{
				$this->_data = $this->_items;
			}
			
		}

		return $this->_data;
	}

	public function getParent()
	{
		if(!is_object($this->_parent)) {
			$this->getItems();
		}
		return $this->_parent;
	}
	public function getSettings()
	{
		$id					= 1;
		$settings  			= JTable::getInstance('Settings', 'jetestimonialTable');
		$settings->load($id);

		return $settings;
	}
}