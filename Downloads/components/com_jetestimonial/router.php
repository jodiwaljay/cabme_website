<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * Build the route for the com_jetestimonial component
  */
function jetestimonialBuildRoute(&$query)
{
	$segments 		= array();

	if (isset($query['task'])) {
		$segments[] = $query['task'];
		unset($query['task']);
	}
	if (isset($query['id'])) {
		$segments[] = $query['id'];
		unset($query['id']);
	}

	return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 * index.php?/banners/task/id/Itemid
 *
 * index.php?/banners/id/Itemid
 */
function jetestimonialParseRoute($segments)
{
	$vars 					= array();

	// view is always the first element of the array
	$count 					= count($segments);

	if ($count)
	{
		$count--;
		$segment 			= array_shift($segments);
		if (is_numeric($segment)) {
			$vars['id'] 	= $segment;
		} else {
			$vars['task'] 	= $segment;
		}
	}

	if ($count)
	{
		$count--;
		$segment 			= array_shift($segments) ;
		if (is_numeric($segment)) {
			$vars['id'] 	= $segment;
		}
	}

	return $vars;
}