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
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$doc   = JFactory::getDocument();
$css   = JURI::base().'modules/mod_jefadertestimonial/assets/css/style.css';
$doc->addStyleSheet($css);

$readmore 	    				= $params->get ( 'readmore' );
$readmore_text  				= $params->get ( 'readmore_text' );
$readmore_align 				= $params->get ( 'readmore_align' );
$limit	 	    				= $params->get ( 'limit' );
$order	 	    				= $params->get ( 'order' );
$sort_set	 	    			= $params->get ( 'sort' );
$limit	 	    				= $params->get ('limit', '100');
$display_posted_date			= $params->get ('display_posted_date', '1');
$readmore 	    				= $params->get ('readmore', '1');
$readmore_text  				= $params->get ('readmore_text', 'Read More');
$readmore_align 				= $params->get ('readmore_align', 'right');
$display_add_testimonial_link	= $params->get ('display_add_testimonial_link',1);
$display_all_testimonial_link	= $params->get ('display_all_testimonial_link',1);
$add_all_testimonial_postion	= $params->get ('add_all_testimonial_postion',1);
$add_all_link_position			= $params->get ('add_all_link_position','right');
$category 						= $params->get ('category');
$jextn_date_format				= $params->get ('jextn_date_format', 1);
$display_release_date			= $params->get ('display_release_date', '1');

$testimonials					= modFadertestimonialHelper::display($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require(JModuleHelper::getLayoutPath('mod_jefadertestimonial','default'));

?>



