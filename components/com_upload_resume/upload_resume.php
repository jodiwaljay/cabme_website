<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Upload_resume
 * @author     Rekha <rekhakl@redwebdesign.in>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Upload_resume', JPATH_COMPONENT);
JLoader::register('Upload_resumeController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Upload_resume');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
