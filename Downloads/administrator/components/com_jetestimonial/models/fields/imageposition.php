<?php
/**
 * JE FAQPro package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of Sortby
 */
class JFormFieldImageposition extends JFormFieldList
{
	/**
	 * @var		string	The form field type.
	 */
	public $type = 'Imageposition';

	/**
	 * Method to get the field options.
	 */
	protected function getOptions()
	{
		$options = array(
			JHTML::_('select.option',  'left', JText::_( 'JE_POSITION_LEFT' )),
			JHTML::_('select.option',  'right', JText::_( 'JE_POSITION_RIGHT' )),
		);

		return $options;
	}
}