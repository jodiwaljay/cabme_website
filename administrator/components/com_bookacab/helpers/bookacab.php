<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Bookacab
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Bookacab helper.
 *
 * @since  1.6
 */
class BookacabHelpersBookacab
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_BOOKACAB_TITLE_BOOKCABS'),
			'index.php?option=com_bookacab&view=bookcabs',
			$vName == 'bookcabs'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_BOOKACAB_TITLE_CABTYPES'),
			'index.php?option=com_bookacab&view=cabtypes',
			$vName == 'cabtypes'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_BOOKACAB_TITLE_POSTCABS'),
			'index.php?option=com_bookacab&view=postcabs',
			$vName == 'postcabs'
		);



	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_bookacab';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
