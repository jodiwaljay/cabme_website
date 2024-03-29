<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class JetestimonialTableSettings extends JTable
{
	public function __construct(& $db)
	{
		parent::__construct( '#__jetestimonial_settings', 'id', $db );
	}
}
?>
