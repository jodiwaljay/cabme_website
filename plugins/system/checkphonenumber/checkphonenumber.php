<?php
/**
 * @copyright	Copyright (c) 2016 CheckPhonenumber. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * system - CheckPhonenumber Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	CheckPhonenumber.CheckPhonenumber
 */
class plgsystemCheckPhonenumber extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}
	
	function onAfterRoute(){

		$user = JFactory::getUser();
		$app = JFactory::getApplication();
		$view = JRequest::getVar("view","");
		$task = JRequest::getVar("task","");

		if($app->isSite() && $user->id > 0 && empty($user->mobile) && $task != "postcabform.updatephone" && $task != "user.logout" && $view != "postcabform"){
			$app->Redirect("index.php?option=com_bookacab&view=postcabform&layout=phonenumber");
			return false;
		}
	}

}