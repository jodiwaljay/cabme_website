<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Bookacab
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
session_start();

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

use Joomla\Utilities\ArrayHelper;
/**
 * Bookacab model.
 *
 * @since  1.6
 */
class BookacabModelPostcabForm extends JModelForm
{
	private $item = null;

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return void
	 *
	 * @since  1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('com_bookacab');

		// Load state from the request userState on edit or from the passed variable on default
		if (JFactory::getApplication()->input->get('layout') == 'edit')
		{
			$id = JFactory::getApplication()->getUserState('com_bookacab.edit.postcab.id');
		}
		else
		{
			$id = JFactory::getApplication()->input->get('id');
			JFactory::getApplication()->setUserState('com_bookacab.edit.postcab.id', $id);
		}

		$this->setState('postcab.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();

		if (isset($params_array['item_id']))
		{
			$this->setState('postcab.id', $params_array['item_id']);
		}

		$this->setState('params', $params);
	}

	/**
	 * Method to get an ojbect.
	 *
	 * @param   integer  $id  The id of the object to get.
	 *
	 * @return Object|boolean Object on success, false on failure.
	 *
	 * @throws Exception
	 */
	public function &getData($id = null)
	{
		if ($this->item === null)
		{
			$this->item = false;

			if (empty($id))
			{
				$id = $this->getState('postcab.id');
			}

			// Get a level row instance.
			$table = $this->getTable();

			// Attempt to load the row.
			if ($table !== false && $table->load($id))
			{
				$user = JFactory::getUser();
				$id   = $table->id;

				if ($id)
				{
					$canEdit = $user->authorise('core.edit', 'com_bookacab. postcab.' . $id) || $user->authorise('core.create', 'com_bookacab. postcab.' . $id);
				}
				else
				{
					$canEdit = $user->authorise('core.edit', 'com_bookacab') || $user->authorise('core.create', 'com_bookacab');
				}

				if (!$canEdit && $user->authorise('core.edit.own', 'com_bookacab.postcab.' . $id))
				{
					$canEdit = $user->id == $table->created_by;
				}

				if (!$canEdit)
				{
					throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 500);
				}

				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published)
					{
						return $this->item;
					}
				}

				// Convert the JTable to a clean JObject.
				$properties  = $table->getProperties(1);
				$this->item = ArrayHelper::toObject($properties, 'JObject');
			}
		}

		return $this->item;
	}

	/**
	 * Method to get the table
	 *
	 * @param   string  $type    Name of the JTable class
	 * @param   string  $prefix  Optional prefix for the table class name
	 * @param   array   $config  Optional configuration array for JTable object
	 *
	 * @return  JTable|boolean JTable if found, boolean false on failure
	 */
	public function getTable($type = 'Postcab', $prefix = 'BookacabTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_bookacab/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get an item by alias
	 *
	 * @param   string  $alias  Alias string
	 *
	 * @return int Element id
	 */
	public function getItemIdByAlias($alias)
	{
		$table = $this->getTable();

		$table->load(array('alias' => $alias));

		return $table->id;
	}

	/**
	 * Method to check in an item.
	 *
	 * @param   integer  $id  The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('postcab.id');

		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param   integer  $id  The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('postcab.id');

		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = JFactory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Method to get the profile form.
	 *
	 * The base form is loaded from XML
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return    JForm    A JForm object on success, false on failure
	 *
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_bookacab.postcab', 'postcabform', array(
			'control'   => 'jform',
			'load_data' => $loadData
			)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return    mixed    The data for the form.
	 *
	 * @since    1.6
	 */
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_bookacab.edit.postcab.data', array());

		if (empty($data))
		{
			$data = $this->getData();
		}



		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 1.6
	 */
	public function save($data)
	{
		$id    = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('postcab.id');
		$state = (!empty($data['state'])) ? 1 : 0;
		$user  = JFactory::getUser();
		$normaldate=$_POST['jform']['date'];
		$pickup=$_POST['pickuppoints'];
		   for($i=0;$i<count($pickup);$i++)
	       {
                $pickuplists[]=$pickup[$i];
	       }
	       //$data['pickuppoints']=implode("|",$lists);
	       $data['pickuppoints']=json_encode($pickuplists,JSON_FORCE_OBJECT);

        $data['date']=date('Y-m-d',strtotime($normaldate));
		$smoke=$_POST['smoke'];
		$data['smoke']=$smoke;
		$pet=$_POST['pet'];
		$data['pet']=$pet;
		$music=$_POST['music'];
		$data['music']=$music;
		$distance=$_POST['distance'];
		$data['distance']=$distance;
		//echo "<pre>";print_r($data);
		//exit;


		/*$input = JFactory::getApplication()->input;
		$file = $input->files->get('image_file', null, 'files', 'array[image_files]');
		$files['image_file'] = $file;*/

		$distance =explode(" ",$data['distance']);
		$distancekm = $distance[0];
		$distancekm = intval(preg_replace('/[^\d.]/', '', $distancekm));
		$rate_perkm = $data['rate_perkm'];
		$totlafare = $distancekm*$rate_perkm;
		$data['totalfare'] = $totlafare;

		//echo "<pre>";print_r($data);exit;
		//exit;
		if ($id)
		{
			// Check the user can edit this item
			$authorised = $user->authorise('core.edit', 'com_bookacab.postcab.' . $id) || $authorised = $user->authorise('core.edit.own', 'com_bookacab.postcab.' . $id);
		}
		else
		{
			// Check the user can create new items in this section
			$authorised = $user->authorise('core.create', 'com_bookacab');
		}

		if ($authorised !== true)
		{
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$table = $this->getTable();



		if ($table->save($data) === true)
		{
			unset($_SESSION['date']);
			unset($_SESSION['time']);
			unset($_SESSION['from']);
			unset($_SESSION['to']);
			unset($_SESSION['cab_type']);

			return $table->id;

		}
		else
		{
			return false;
		}
	}

	/**
	 * Method to delete data
	 *
	 * @param   array  $data  Data to be deleted
	 *
	 * @return bool|int If success returns the id of the deleted item, if not false
	 *
	 * @throws Exception
	 */
	public function delete($data)
	{
		$id = (!empty($data['id'])) ? $data['id'] : (int) $this->getState('postcab.id');

		if (JFactory::getUser()->authorise('core.delete', 'com_bookacab.postcab.' . $id) !== true)
		{
			throw new Exception(403, JText::_('JERROR_ALERTNOAUTHOR'));
		}

		$table = $this->getTable();

		if ($table->delete($data['id']) === true)
		{
			return $id;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Check if data can be saved
	 *
	 * @return bool
	 */
	public function getCanSave()
	{
		$table = $this->getTable();

		return $table !== false;
	}
	public function getlist($list)
	{
        $exp=explode(",",$list);
        $db = JFactory::getDBO();
        if(!empty($list))
        {
	        $query = 'SELECT * FROM #__postacab WHERE cab_type IN("' .implode('", "',$exp). '")';
	        $db->setQuery($query);
	        $results = $db->loadObjectlist();
        }
        else
        {
            $query = 'SELECT * FROM #__postacab';
	        $db->setQuery($query);
	        $results = $db->loadObjectlist();
        }
        return $results;
	}

	public function getpostContact($cabtype)
	{
		$db = JFactory::getDbo();
		$sql="select name,title,mobile,cab_type from #__usergroups as usrg LEFT JOIN #__users as usr ON usrg.id=usr.user_group where usr.cab_type=$cabtype";
		$db->setQuery($sql);
		$results=$db->loadObjectlist();
		//print_r($results);
		//exit;
		return $results;
	}


}
