<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Ride_details
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Ride_details', JPATH_COMPONENT);

// Execute the task.
$controller = JControllerLegacy::getInstance('Ride_details');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
