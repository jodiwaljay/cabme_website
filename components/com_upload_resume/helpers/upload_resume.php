<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Upload_resume
 * @author     Rekha <rekhakl@redwebdesign.in>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class Upload_resumeFrontendHelper
 *
 * @since  1.6
 */
class Upload_resumeHelpersUpload_resume
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
		if (file_exists(JPATH_SITE . '/components/com_upload_resume/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_upload_resume/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'Upload_resumeModel');
		}

		return $model;
	}
}
