<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// No direct access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

/**
 * JE Testimonial Component Controller
 */
class jetestimonialController extends JControllerLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	/**
	 * Method to display a view.
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable		= true;

		// Get the document object.
			$document	= JFactory::getDocument();

		// Set the default view name and format from the Request.
			$vName		= JRequest::getCmd('view', 'testimonials');
			JRequest::setVar('view', $vName);

		$user			= JFactory::getUser();

		$safeurlparams = array('catid'=>'INT','id'=>'INT','cid'=>'ARRAY','year'=>'INT','month'=>'INT','limit'=>'INT','limitstart'=>'INT',
			'showall'=>'INT','return'=>'BASE64','filter'=>'STRING','filter_order'=>'CMD','filter_order_Dir'=>'CMD','filter-search'=>'STRING','print'=>'BOOLEAN','lang'=>'CMD');

		parent::display($cachable,$safeurlparams);

		return $this;
	}
}
