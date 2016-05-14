<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Driver_details
 * @author     Tabrez ulla khan <tabrez@redwebdesign.in>
 * @copyright  Copyright (C) 2016. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('Driver_detailsFrontendHelper', JPATH_COMPONENT . '/helpers/driver_details.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('Driver_details');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
