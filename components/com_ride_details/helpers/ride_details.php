<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Ride_details
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class Ride_detailsFrontendHelper
 *
 * @since  1.6
 */
class Ride_detailsFrontendHelper
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_ride_details/models/' . strtolower($name) . '.php'))
		{
			$model = JModelLegacy::getInstance($name, 'Ride_detailsModel');
		}

		return $model;
	}
}
