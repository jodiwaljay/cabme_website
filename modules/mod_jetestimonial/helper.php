<?php
/**
 * jeTestimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined('_JEXEC') or die;

class modJetestimonialHelper
{
	static function getTestimonial($params)
	{
		$category 		= $params->get('category');
		$sort_set			= $params->get('sort', 'ordering');
		
		//random
		
		if($sort_set==="random"){
			$sort_set			= 'rand()'	;

		}else{
			$sort_set			= $params->get('sort', 'ordering');

		}
		$order			= $params->get('order', 'desc');
		$todaydate1='\''.date('Y-m-d').'\'';
		$db				= JFactory::getDBO();
		$query			= $db->getQuery(true);

		if($category == 0){
			$query->select('*');
			$query->from('#__jetestimonial_testimonials');
			$query->where('published = 1');
			$query->where('releasedate<='.$todaydate1);
			$query->order($sort_set.' '.$order);

		} else{
			$query->select('*');
			$query->from('#__jetestimonial_testimonials');
			$query->where('published = 1');
			$query->where('releasedate<='.$todaydate1);
			$query->where('releasedate<='.$todaydate1);
			$query->where('catid ='.$category);
			$query->order($sort_set.' '.$order);
		}

		$db->setQuery( $query);

		$testimonials	= $db->loadObjectList();		
		return $testimonials;
	}
}