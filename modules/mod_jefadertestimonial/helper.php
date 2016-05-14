<?php
/**
 * jeFaderTestimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class modFadertestimonialHelper
{
		static function display( $params )
		{
			$db				= JFactory::getDBO();
			$query			= $db->getQuery(true);
			$sort_set		= $params->get('sort', 'ordering');

			//random

			if($sort_set==="random"){
				$sort_set			= 'rand()';
			}else{
				$sort_set			= $params->get('sort', 'ordering');
			}
			$order			= $params->get('order', 'desc');
			$orderby  	  = ' ORDER BY '.$sort_set.' '.$order;
			$todaydate1		='\''.date('Y-m-d').'\'';
			$category 		= $params->get('category');

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
			$query->where('catid ='.$category);
			$query->order($sort_set.' '.$order);
		}
			$db->setQuery( $query);
			$testimonials = $db->loadObjectList();

			if (count($testimonials)<1) {
				echo JText :: _('MOD_MES');
				return true;
			}
			return $testimonials;
		}
}
?>


