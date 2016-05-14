<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.categories');

/**
 * JE Testimonial Component Category Tree
 */
class jetestimonialCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table'] = '#__jetestimonial_testimonials';
		$options['extension'] = 'com_jetestimonial';
		$options['published'] = 'published';
		parent::__construct($options);
	}
}