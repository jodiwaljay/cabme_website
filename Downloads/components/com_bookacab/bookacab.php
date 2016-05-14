<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Bookacab
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Bookacab', JPATH_COMPONENT);

// Execute the task.
$controller = JControllerLegacy::getInstance('Bookacab');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
