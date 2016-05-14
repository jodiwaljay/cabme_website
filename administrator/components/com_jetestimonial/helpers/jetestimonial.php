<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

class jetestimonialHelper
{

	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_JETESTIMONIAL_TESTIMONIALS'),
			'index.php?option=com_jetestimonial&view=testimonials',
			$vName == 'testimonials'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_JETESTIMONIAL_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_jetestimonial',
			$vName == 'categories'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_JETESTIMONIAL_GLOBALSETTINGS'),
			'index.php?option=com_jetestimonial&task=settings.edit&id=1',
			$vName 				== 'settings'
		);

		if ($vName=='categories') {
			JToolBarHelper::title( JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_jetestimonial')), 'faq-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 */
	public static function getActions($categoryId = 0)
	{
		$user			= JFactory::getUser();
		$result			= new JObject;

		if (empty($categoryId)) {
			$assetName	= 'com_jetestimonial';
		} else {
			$assetName	= 'com_jetestimonial.category.'.(int) $categoryId;
		}

		$actions 		= array ( 'core.admin', 'core.manage', 'core.create',
								  'core.edit', 'core.edit.state', 'core.delete'
								);

		foreach ($actions as $action) {
			$result->set( $action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
