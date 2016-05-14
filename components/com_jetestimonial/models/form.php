<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// No direct access
defined('_JEXEC') or die;

// Base this model on the backend version.
	require_once JPATH_ADMINISTRATOR.'/components/com_jetestimonial/models/testimonial.php';

/**
 * JE Testimonial Component Form Model
 */
class jetestimonialModelForm extends jetestimonialModelTestimonial
{
	/**
	 * Method to auto-populate the model state.
	 */
	protected function populateState()
	{
		$app					= JFactory::getApplication();

		// Load state from the request.
			$pk					= JRequest::getInt('a_id');
			$this->setState('testimonial.id', $pk);

		$this->setState('testimonial.catid', JRequest::getInt('catid'));

		$return					= JRequest::getVar('return', null, 'default', 'base64');
		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
			$params				= $app->getParams();
			$this->setState('params', $params);

		$this->setState('layout', JRequest::getCmd('layout'));
	}

	/**
	 * Method to get Testimonial data.
	 */
	public function getItem($itemId = null)
	{
		// Initialise variables.
			$itemId				= (int) (!empty($itemId)) ? $itemId : $this->getState('testimonial.id');

		// Get a row instance.
			$table				= $this->getTable();

		// Attempt to load the row.
			$return				= $table->load($itemId);

		// Check for a table object error.
			if ($return === false && $table->getError()) {
				$this->setError($table->getError());
				return false;
			}

		$properties				= $table->getProperties(1);
		$value					= JArrayHelper::toObject($properties, 'JObject');

		// Convert attrib field to Registry.
			$value->params		= new JRegistry;

		// Compute selected asset permissions.
			$user				= JFactory::getUser();
			$userId				= $user->get('id');
			$asset				= 'com_jetestimonial.testimonial.'.$value->id;

		// Check general edit permission first.
			if ($user->authorise('core.edit', $asset)) {
				$value->params->set('access-edit', true);
			}


		// Now check if edit.own is available.
			else if (!empty($userId) && $user->authorise('core.edit.own', $asset)) {
				// Check for a valid user and that they are the owner.
					if ($userId == $value->created_by) {
						$value->params->set('access-edit', true);
					}
			}

		// Check edit state permission.
			if ($itemId) {
				// Existing item
					$value->params->set('access-change', $user->authorise('core.edit.state', $asset));
			} else {
				// New item.
					$catId		= (int) $this->getState('testimonials.catid');
					if ($catId) {
						$value->params->set('access-change', $user->authorise('core.edit.state', 'com_jetestimonial.category.'.$catId));
					} else {
						$value->params->set('access-change', $user->authorise('core.edit.state', 'com_jetestimonial'));
					}
			}

		return $value;
	}

	/**
	 * Get the return URL.
	 */
	public function getReturnPage()
	{
		return base64_encode('index.php?option=com_jetestimonial&view=form&layout=edit');
	}
}