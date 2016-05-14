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
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$doc   = JFactory::getDocument();
$css   = JURI::base().'modules/mod_jetestimonial/assets/css/style.css';
$doc->addStyleSheet($css);
/*Direction : 1 => default(leftright) 2 => rightleft 3 =>topbottom 4 =>bottomtop */
$je_module_id   = $module->id;
$je_direction 	= $params->get('layout', '1');
$avatarshow		= $params->get('avatardisplay');
$readmore 	    = $params->get('readmore', '1');
$readmore_text  = $params->get('readmore_text', 'Read More');
$readmore_align = $params->get('readmore_align', 'right');
$limit	 	    = $params->get('limit', '100');
$order	 	    = $params->get('order', 'desc');
$sort_set	 	= $params->get('sort', 'ordering');
$category 		= $params->get('category');

$display_title 					= $params->get('display_title',1);
$display_name 					= $params->get('display_name',1);
$display_company_name 			= $params->get('display_company_name',1);
$display_city 					= $params->get('display_city',1);
$display_state 					= $params->get('display_state',1);
$display_country 				= $params->get('display_country',1);
$display_website 				= $params->get('display_website',1);
$display_email 					= $params->get('display_email',1);
$display_posted_date			= $params->get('display_posted_date',1);
$display_release_date			= $params->get('display_release_date', '1');
$display_add_testimonial_link	= $params->get('display_add_testimonial_link',1);
$display_all_testimonial_link	= $params->get('display_all_testimonial_link',1);
$add_all_testimonial_postion	= $params->get('add_all_testimonial_postion',1);
$add_all_link_position			= $params->get('add_all_link_position','center');
$jextn_date_format				= $params->get('jextn_date_format', 1);


$testimonials	 = modJetestimonialHelper::getTestimonial($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_jetestimonial', "default");

?>