<?php
/**
 * @module		com_ola
 * @script		ola.php
 * @author-name Christophe Demko
 * @adapted by  Ribamar FS
 * @copyright	Copyright (C) 2012 Christophe Demko
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
define('DS', DIRECTORY_SEPARATOR);

/**
 * Script file of Ola component
 */
class com_jetestimonialInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		$this->installitems();
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
	
		$db			= & JFactory::getDBO();

		// Remove the JE Testimonial Module from the site..
		if(JFolder::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jetestimonial')) {
			JFolder::delete(JPATH_ROOT.DS.'modules'.DS.'mod_jetestimonial');
		}

		if (JFile::exists(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.ini')) {
			JFile::delete(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.ini');
		}

		if (JFile::exists(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.sys.ini')) {
			JFile::delete(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.sys.ini');
		}
		
		if(JFolder::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial')){
			JFolder::delete(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial');
		}
		
		if (JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini')) {
			JFile::delete(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini');
		}

		if (JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.sys.ini')) {
			JFile::delete(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.sys.ini');
		}
		
		// Code for uninstall module
		// Remove the module names from the module table
			$query			= $db->getQuery(true);

			$query->select('id');
			$query->from('#__modules');
			$query->where("module = mod_jetestimonial'");
			$db->setQuery( $query);

			$id 				= $db->loadResult();

			$query = 'DELETE  FROM `#__modules_menu` WHERE `moduleid`='."'$id '";
			$db->setQuery( $query );
			$db->query();

			$query = "DELETE  FROM `#__modules` WHERE `module`= 'mod_jetestimonial'";
			$db->setQuery( $query );
			$db->query();

			$query = "DELETE  FROM `#__extensions` WHERE `element`='mod_jetestimonial' AND `type` = 'module'";
			$db->setQuery( $query );
			$db->query();
		// Code ended for uninstall jeTestimonial module
		
		//Code for uninstall the jeTestimonial plugin
			$query			= $db->getQuery(true);
			
			$query->select('extension_id');
			$query->from('#__extensions');
			$query->where("element = 'jetestimonial'");
			$db->setQuery( $query);

			$extension_id 				= $db->loadResult();
			
			$query = "DELETE  FROM `#__extensions` WHERE `element`='jetestimonial' AND `type` = 'plugin'";
			$db->setQuery( $query );
			$db->query();
		// Code ended for uninstall jeTestimonial plugin

		echo '<p> <b> <span style="color:#009933"> JE Testimonial Component, Module and Plugin has been Uninstalled successfully </span></b> </p>';

	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		$this->installitems();
	}
	
	function installitems(){
	
		$status		=  true;
	// Joomla predefiend function to connect db
		$db			=  JFactory::getDBO();

	// Insert default configuration details
		$query 		= "SELECT count(*) FROM #__jetestimonial_testimonials";
		$db->setQuery( $query );
		$total_rows = $db->loadResult();
		
	// Check whether the field is there.
		//$query = "SELECT `state` FROM #__jetestimonial_testimonials";
		//$db->setQuery( $query );
		$db->setQuery('SHOW FULL COLUMNS FROM #__jetestimonial_testimonials where field = "state"');
		$state = $db->loadObject();

		if(!$state)
		{
			$db = JFactory::getDBO();
			$query = "ALTER TABLE `#__jetestimonial_testimonials` ADD `state` varchar(255) NOT NULL AFTER `city`";
			$db->setQuery( $query );
			$db->query();
		}		
		
	// Insert default configuration details
		$query 		= "SELECT count(*) FROM #__jetestimonial_settings";
		$db->setQuery( $query );
		$total_rows = $db->loadResult();

	// Check the whether the data's already there.
		if(!$total_rows) {
			$query  = "INSERT INTO `#__jetestimonial_settings` " .
					" (`id`, `theme`, `orderby`, `sortby`, `image_resize`, `height`, `width`, `image_position`,`show_introtext`,`cat_image_resize`,`cat_image_height`,`cat_image_width`,`show_image`) ".
					" VALUES " .
					" (1, 1, 'ordering', 'desc', '1', '100', '100', 'left','0','0','40','0','1')";
			$db->setQuery( $query );
			$db->query();
		}
		
		//pagination and pagination limit
		// Check the whether the data's already there.
		$db = JFactory::getDBO();
		$db->setQuery('SHOW FULL COLUMNS FROM `#__jetestimonial_settings` where field = "show_pagination_jextn"');
		$total_rows = $db->loadObject();
		
		if(empty($total_rows)) {
			$db = JFactory::getDBO();
			$query  ="ALTER TABLE `#__jetestimonial_settings` ADD `show_pagination_jextn` tinyint( 3 ) NOT NULL AFTER  `show_image`,
				      ADD `pagination_limit` int( 11 ) NOT NULL AFTER  `show_pagination_jextn`";
			$db->setQuery( $query );
			$db->query();
		}

	// Check the whether the data's already there.
		if(!$total_rows) {
			$db = JFactory::getDBO();
			$query  = "UPDATE `#__jetestimonial_settings` SET `show_pagination_jextn`='0' WHERE id='1'";
			$db->setQuery( $query );
			$db->query();
		}
		
		// Check the whether the data's already there.
		if(!$total_rows) {
			$db = JFactory::getDBO();
			$query  = "UPDATE `#__jetestimonial_settings` SET `pagination_limit`='5' WHERE id='1'";
			$db->setQuery( $query );
			$db->query();
		}
		
	// Check the whether the data's already there.

			
	// Insert template styles..
		$query 		= "SELECT count(*) FROM #__jetestimonial_themes";
		$db->setQuery( $query );
		$total_rows = $db->loadResult();

		if(!$total_rows) {
			$query = "INSERT INTO `#__jetestimonial_themes` (`id`, `themes`) VALUES
					(1, 'Mysterious'),
					(2, 'Rythm Blue'),
					(3, 'Loyalty'),
					(4, 'Red Pearl'),
					(5, 'Achromatic gray'),
					(6, 'Sunshine'),
					(7, 'Bravey'),
					(8, 'Orange'),
					(9, 'Blue'),
					(10, 'Green'),
					(11, 'Blue 2'),
					(12, 'Green 2'),
					(13, 'Purple')";
			$db->setQuery( $query );
			$db->query();
			$total_rows = 13;
		}
		if($total_rows<8) {
			$query = "INSERT INTO `#__jetestimonial_themes` (`id`, `themes`) VALUES
					(8, 'Orange'),
					(9, 'Blue'),
					(10, 'Green'),
					(11, 'Blue 2'),
					(12, 'Green 2'),
					(13, 'Purple')";
			$db->setQuery( $query );
			$db->query();
		}
	// Code for Install jetestimonial content plugin.
			
		if(!JFolder::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial')) {
			JFolder::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial', JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial');
			
			if (!JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.php')) {
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial.php',JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.php');
			}
			
			if (!JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'pagination.php')) {
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial'.DS.'pagination.php',JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'pagination.php');
			}
			
			if (!JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.xml')) {
				JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial.xml',JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.xml');
			}
			
			if (!JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini')) {
				JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'en-GB.plg_content_jetestimonial.ini',JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini');
			}	
			if (!JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.sys.ini')) {
				JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'en-GB.plg_content_jetestimonial.sys.ini',JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.sys.ini');
			}				
			
			if(JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.php') && JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.xml') && JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini') && JFolder::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial')) {
			
					$query = "INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `system_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) VALUES ('', 'Content - JETestimonial', 'plugin', 'jetestimonial', 'content', '', '0', '1', '0', '', '{\"sort\":\"ordering\",\"order\":\"desc\"}', '', '', '0', '0000-00-00 00:00:00', '0', '0');";
					$db->setQuery( $query );
					$db->query();	

				if(JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial')){
					JFolder::delete(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial');
				}
			}
		}else{
			JFolder::delete(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial');
			
			JFolder::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial', JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial');
			
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial.php',JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.php');
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial.xml',JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.xml');

			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'jetestimonial'.DS.'pagination.php',JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'pagination.php');				
			
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'en-GB.plg_content_jetestimonial.ini',JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini');		

			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial'.DS.'en-GB.plg_content_jetestimonial.sys.ini',JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.sys.ini');			

			JFolder::delete(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'plg_jeTestimonial');			
			
			}
		
		// Install JE Testimonial Module
		if(!JFolder::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jetestimonial')){

			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jetestimonial'.DS.'en-GB.mod_jetestimonial.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.ini');
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jetestimonial'.DS.'en-GB.mod_jetestimonial.sys.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.sys.ini');

			JFolder::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jetestimonial', JPATH_ROOT.DS.'modules'.DS.'mod_jetestimonial');

			$mod				=  new stdClass();

			$mod->title			= 'JE Testimonial';
			$mod->ordering		= '1';
			$mod->position		= 'position-7';
			$mod->published		= '1';
			$mod->module		= 'mod_jetestimonial';
			$mod->access		= '1';
			$mod->showtitle		= '1';
			$mod->params		= '{"height":"300","width":"225","bgcolor":"#fff","speed":"3000","degree":"10","layout":"default","avatardisplay":"1","readmore":"1","readmore_text":"Read More","readmore_align":"right","limit":"100","sort":"ordering","order":"desc","category":"","moduleclass_sfx":"","cache":"1","cache_time":"900"}';

			$stored				= $db->insertObject('#__modules', $mod);

			// If the store failed return false.
			if (!$stored) {
				JError::raiseWarning('', JText::_('COM_JETWEETS_MODULENOTINSTSALLED'));
				$status			=  false;
			} else {

				$query			= $db->getQuery(true);
				$query->select('id');
				$query->from('#__modules');
				$query->where("module = 'mod_jetestimonial'");
				$db->setQuery( $query);
				$id 				= $db->loadResult();

				$modid				= new stdClass();
				$modid->moduleid	= $id;
				$modid->menuid		= '0';

				$modmenustored		= $db->insertObject('#__modules_menu', $modid);
				if (!$modmenustored) {
					JError::raiseWarning('', JText::_('COM_JETWEETS_MODULENOTINSTSALLED'));
					$status			=  false;
				}

				$extension					= new stdClass();

				$extension->name			= 'JE Testimonial';
				$extension->type			= 'module';
				$extension->element			= 'mod_jetestimonial';
				$extension->enabled			= '1';
				$extension->access			= '1';
				$extension->manifest_cache	= '{"legacy":false,"name":"JE Testimonial","type":"module","creationDate":"April - 2011","author":"JExtension","copyright":"Copyright (C) 2005 - 2011 Open Source Matters. All rights reserved.","authorEmail":"contact@jextn.com","authorUrl":"www.jextn.com","version":"2.0.0","description":"MOD_JETESTIMONIAL_XML_DESCRIPTION","group":""}';
				$extension->params			= '{"height":"290","width":"250","bgcolor":"#fff","speed":"3000","degree":"10","layout":"default","readmore":"1","readmore_text":"Read More","readmore_align":"right","limit":"100","sort":"ordering","order":"desc","cache":"1","cache_time":"900"}';

				$extnstored					= $db->insertObject('#__extensions', $extension);
				if (!$extnstored) {
					JError::raiseWarning('', JText::_('COM_JETWEETS_MODULENOTINSTSALLED'));
					$status					=  false;
				}
			}
		} else {
			JFile::delete(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.ini');
			JFile::delete(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.sys.ini');
			JFolder::delete(JPATH_ROOT.DS.'modules'.DS.'mod_jetestimonial');
			
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jetestimonial'.DS.'en-GB.mod_jetestimonial.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.ini');
			JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jetestimonial'.DS.'en-GB.mod_jetestimonial.sys.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jetestimonial.sys.ini');

			JFolder::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jetestimonial', JPATH_ROOT.DS.'modules'.DS.'mod_jetestimonial');
		}
			
		//***Install JE FaderTestimonial Module*****//
		
	if(!JFolder::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jefadertestimonial')){

		JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial'.DS.'en-GB.mod_jefadertestimonial.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jefadertestimonial.ini');
		JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial'.DS.'en-GB.mod_jefadertestimonial.sys.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jefadertestimonial.sys.ini');

		JFolder::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial', JPATH_ROOT.DS.'modules'.DS.'mod_jefadertestimonial');

		$mod1				=  new stdClass();

		$mod1->title		= 'JE FaderTestimonial';
		$mod1->ordering		= '1';
		$mod1->position		= 'position-2';
		$mod1->published	= '1';
		$mod1->module		= 'mod_jefadertestimonial';
		$mod1->access		= '1';
		$mod1->showtitle		= '1';
		$mod1->params		= '{"height":"30","width":"100","bgcolor":"#ffffff","speed":"3000","degree":"10","fontstyle":"italic","sort":"ordering","order":"asc","moduleclass_sfx":"","cache":"1","cache_time":"900"}';

		$stored				= $db->insertObject('#__modules', $mod1);

		// If the store failed return false.
		if (!$stored) {
			JError::raiseWarning('', JText::_('COM_JETWEETS_MODULENOTINSTSALLED'));
			$status			=  false;
		} else {

			$query1			= $db->getQuery(true);
			$query1->select('id');
			$query1->from('#__modules');
			$query1->where("module = 'mod_jefadertestimonial'");
			$db->setQuery( $query1);
			$id 				= $db->loadResult();

			$modid1				= new stdClass();
			$modid1->moduleid	= $id;
			$modid1->menuid		= '0';

			$modmenustored		= $db->insertObject('#__modules_menu', $modid1);
			if (!$modmenustored) {
				JError::raiseWarning('', JText::_('COM_JETWEETS_MODULENOTINSTSALLED'));
				$status			=  false;
			}

			$extension1					= new stdClass();

			$extension1->name			= 'JE FaderTestimonial';
			$extension1->type			= 'module';
			$extension1->element		= 'mod_jefadertestimonial';
			$extension1->enabled		= '1';
			$extension1->access			= '1';
			$extension1->manifest_cache	= '{"legacy":false,"name":"JE FaderTestimonial","type":"module","creationDate":"April - 2011","author":"JExtension","copyright":"Copyright (C) 2005 - 2011 Open Source Matters. All rights reserved.","authorEmail":"contact@jextn.com","authorUrl":"www.jextn.com","version":"2.0.0","description":"MOD_JETESTIMONIAL_XML_DESCRIPTION","group":""}';
			$extension1->params			= '{"height":"30","width":"100","bgcolor":"#ffffff","speed":"3000","degree":"10","fontstyle":"italic","sort":"ordering","order":"asc","moduleclass_sfx":"","cache":"1","cache_time":"900"}';

			$extnstored1					= $db->insertObject('#__extensions', $extension1);
			if (!$extnstored1) {
				JError::raiseWarning('', JText::_('COM_JETWEETS_MODULENOTINSTSALLED'));
				$status					=  false;
			}
		}
		if(JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial')){
			JFolder::delete(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial');
		}	
	} else {
		JFile::delete(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jefadertestimonial.ini');
		JFile::delete(JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jefadertestimonial.sys.ini');
		JFolder::delete(JPATH_ROOT.DS.'modules'.DS.'mod_jefadertestimonial');
	
		JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial'.DS.'en-GB.mod_jefadertestimonial.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jefadertestimonial.ini');
		JFile::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial'.DS.'en-GB.mod_jefadertestimonial.sys.ini', JPATH_ROOT.DS.'language'.DS.'en-GB'.DS.'en-GB.mod_jefadertestimonial.sys.ini');

		JFolder::move(JPATH_ROOT.DS.'components'.DS.'com_jetestimonial'.DS.'mod_jefadertestimonial', JPATH_ROOT.DS.'modules'.DS.'mod_jefadertestimonial');
	}
		
	if($status == true) {
		// Message area.
			echo '<p> <b> <span style="color:#009933"> JE Testimonial component and Module has been Installed Successfully. </span> </b> </p>';
			
			if(JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.php') && JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial'.DS.'jetestimonial.xml') && JFile::exists(JPATH_ROOT.DS.'administrator'.DS.'language'.DS.'en-GB'.DS.'en-GB.plg_content_jetestimonial.ini') && JFolder::exists(JPATH_ROOT.DS.'plugins'.DS.'content'.DS.'jetestimonial')) {
			echo '<p><b> <span style="color:#009933"> -- Also, The jeTestimonial content plugin has been installed successfully. </span><span style="color:#FF0000">Please enable this plugin from Extensions/plugin Manager, And Replaces {testimonial} tag in content. It will be replace the testimonial themes and contents.<br/>
			{testimonial|t|1,2} It will displays the testimonial of id 1 and 2 <br/>
			{testimonial|c|1,2} It will displays all the testimonial from the category id 1 and 2<br/>
			{testimonial|count|1} It will displays only one testimonial from all Testimonials ( Ordering as per backend plugin params )<br/>
			{testimonial|count|1|c|2} It will displays only one testimonial from the category id 2 ( Ordering as per backend plugin params )</span> </b> </p>';
		}
	}
	
}

}
