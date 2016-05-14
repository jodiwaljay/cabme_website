<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Media_details
 * @author     Tabrez ulla khan <tabrez@redwebdesign.in>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class Media_detailsFrontendHelper
 *
 * @since  1.6
 */
class Media_detailsFrontendHelper
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
		if (file_exists(JPATH_SITE . '/components/com_media_details/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_media_details/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Media_detailsModel');
		}

		return $model;
	}
}
