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

///jimport('joomla.application.component.modellist');

class jetestimonialModelTestimonials extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'tm.id',
				'title', 'tm.title',
				'alias', 'tm.alias',
				'name', 'tm.name',
				'ip_address', 'tm.ip_address',
				'description', 'tm.description',
				'published', 'tm.published',
				'catid', 'tm.catid', 'category_title',
				'access', 'tm.access', 'access_level',
				'ordering', 'tm.ordering',
				'language', 'tm.language',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to get the maximum ordering value for each category.
	 */
	function &getCategoryOrders()
	{
		if (!isset($this->cache['categoryorders'])) {
			$db		= $this->getDbo();
			$query	= $db->getQuery(true);

			$query->select('MAX(ordering) as `max`, catid');
			$query->select('catid');
			$query->from('#__jetestimonial_testimonials');
			$query->group('catid');
			$db->setQuery($query);

			$this->cache['categoryorders'] = $db->loadAssocList('catid', 0);
		}

		return $this->cache['categoryorders'];
	}

	/**
	 * Method to auto-populate the model state.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
			$app		= JFactory::getApplication();

		// Adjust the context to support modal layouts.
			if ($layout = JRequest::getVar('layout')) {
				$this->context .= '.'.$layout;
			}

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published		= $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$categoryId		= $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		$access			= $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);

		$language		= $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		// List state information.
			parent::populateState('tm.ordering', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 */
	protected function getStoreId($id = '')
{
		// Compile the store id.
			$id	.= ':'.$this->getState('filter.search');
			$id	.= ':'.$this->getState('filter.published');
			$id	.= ':'.$this->getState('filter.category_id');
			$id	.= ':'.$this->getState('filter.access');
			$id	.= ':'.$this->getState('filter.language');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 */
	protected function getListQuery()
	{
		// Create a new query object.
			$db				= $this->getDbo();
			$query			= $db->getQuery(true);

		// Select the required fields from the table.
			$query->select( $this->getState(
				'list.select',
				'tm.id AS id, ' .
				'tm.title AS title, ' .
				'tm.alias AS alias, ' .
				'tm.name AS name, ' .
				'tm.ip_address AS ip_address, ' .
				'tm.description AS description,'.
				'tm.releasedate AS releasedate,'.
				'tm.catid AS catid,' .
				'tm.published AS published, tm.ordering,'.
				'tm.language'
			) );
			$query->from( '#__jetestimonial_testimonials as tm' );

		// Join over the categories.
			$query->select( 'cat.title AS category_title' );
			$query->join( 'LEFT', '#__categories AS cat ON cat.id = tm.catid' );

		// Join over the asset groups.
			$query->select( 'ag.title AS access_level' );
			$query->join( 'LEFT', '#__viewlevels AS ag ON ag.id = tm.access' );

		// Join over the language
			$query->select( 'l.title AS language_title' );
			$query->join( 'LEFT', '`#__languages` AS l ON l.lang_code = tm.language' );

		// Filter by published state
			$published		= $this->getState('filter.published');
			if (is_numeric($published)) {
				$query->where('tm.published = ' . (int) $published);
			} else if ($published === '') {
				$query->where('(tm.published = 0 OR tm.published = 1)');
			}

		// Filter by search in title & microblog.
			$search			= $this->getState('filter.search');
			if (!empty($search)) {
				if (stripos($search, 'id:') === 0) {
					$query->where('tm.id = '.(int) substr($search, 3));
				} else {
					$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
					$query->where('(tm.title LIKE '.$search.' OR tm.description LIKE '.$search.')');
				}
			}

		// Filter by a single or group of categories.
			$categoryId		= $this->getState('filter.category_id');
			if (is_numeric($categoryId)) {
				$query->where('tm.catid = '.(int) $categoryId);
			} else if (is_array($categoryId)) {
				JArrayHelper::toInteger($categoryId);
				$categoryId	= implode(',', $categoryId);
				$query->where('tm.catid IN ('.$categoryId.')');
			}

		// Filter by access level.
			if ($access = $this->getState('filter.access')) {
				$query->where('tm.access = ' . (int) $access);
			}

		// Filter on the language.
			if ($language = $this->getState('filter.language')) {
				$query->where('tm.language = '.$db->quote($language));
			}

		// Add the list ordering clause.
			$orderCol		= $this->state->get('list.ordering','tm.ordering');
			$orderDirn		= $this->state->get('list.direction','asc');


			if ($orderCol == 'tm.ordering' || $orderCol == 'category_title') {
				$orderCol	= 'cat.title '.$orderDirn.', tm.ordering';
			}

			 $query->order($db->escape($orderCol.' '.$orderDirn));

			return $query;
	}
}
?>
