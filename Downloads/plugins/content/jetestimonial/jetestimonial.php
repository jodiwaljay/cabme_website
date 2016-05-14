<?php
/**
 * jeTestimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');
jimport('joomla.html.pagination');
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}


/**
 * Class plgContentEcomportfolio
 * @author Daniel Gutierrez
 * .'\languages\en-GB\en-GB.'
 */
class plgContentjetestimonial extends JPlugin
{

	/**
	 * Constructor
	 * For php4 compatability
	 * @since 1.1
	 */
	function plgContentjetestimonial( &$subject, $params )
	{
		parent::__construct( $subject, $params );

		$language 					= JFactory::getLanguage();
		$language->load('plg_content_jetestimonial', JPATH_ADMINISTRATOR);
	}

	/**
	 * Replace the testimonials and show testimonial contents and themes in article
	 */
	public function onContentPrepare($context, &$row, &$params, $page=0 )
	{
		$portfolio = "";

		// simple performance check to determine whether bot should process further
		if ( JString::strpos( $row->text, '{testimonial' ) === false ) {
			return true;
		}

		// define the regular expression for the bot
		$regex = '/{testimonial\s*.*?}/i';

		// check whether plugin has been unpublished
		if ( !$this->params->get( 'enabled', 1 ) )	{
		        $row->text = preg_replace( $regex, '', $row->text );
		        return true;
		}

		// find all instances of plugin and put in $url_video
		preg_match_all( $regex, $row->text, $matches);

		// Number of plugins
		$count = count( $matches[0] );

		// Plugin only processes if there are any instances of the plugin in the text
		if ( $count ) {
			$row->text = preg_replace_callback( $regex, array($this, 'getPortfolio'), $row->text );
		}
	}

	function get_between ($text, $s1, $s2) {
		$mid_url 	= "";
		$pos_s 		= strpos($text,$s1);
		$pos_e 		= strpos($text,$s2);
		for ( $i=$pos_s+strlen($s1) ; (( $i<($pos_e)) && $i < strlen($text)) ; $i++ ) {
			$mid_url .= $text[$i];
		}
		return $mid_url;
	}

	/**
	 * Display the portfolio images
	 * @param array $matches A array with regex content.
	 */
	protected function getPortfolio(&$matches)
	{

		$testimonialtext 					= explode("|",$this->get_between($matches[0],'{','}'));

		jimport('libraries.joomla.application.application.php');

		$app = JFactory::getApplication();

			$context			= 'com_jetestimonial.s.id.list.';
			$sort_set 			= $this->params->get('sort');
			//random
			if($sort_set==="random"){
				$sort_order			= "rand()";
			}else{
				$sort_order			= 's.'.$sort_set;
			}
			$param 						= JComponentHelper::getParams( 'com_jetestimonial' );
			$filter_order				= $app->getUserStateFromRequest( $context.'filter_order',		'filter_order',	$sort_order,	'cmd' );
			//$limit					= $app->getUserStateFromRequest($context.'limit', 'limit', $param->get('list_limit'), 'int');
			$limitstart 				= $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
			$settings 					= $this->getSettings();
			$show_pagination_jextn 		= $settings->show_pagination_jextn;
			$pagination_limit			= $settings->pagination_limit;
			$pagination_limit_increase	= $pagination_limit+1;
 			$show_date_format_je			= $param->get('show_date_format_je', 1);

			/*pagination backend setting*/
			if($show_pagination_jextn){
				if($pagination_limit < $pagination_limit_increase){
				$limit			= $app->getUserStateFromRequest($context . $pagination_limit, $pagination_limit, $pagination_limit, 'int');
				}
			}else{
				$limit				= $app->getUserStateFromRequest($context.'limit', 'limit', $param->get('list_limit'), 'int');
			}

	        $limitstart 		= ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

			// function for total count
			$total     			= $this->getTotal($filter_order,$testimonialtext);

			require_once(JPATH_SITE.DS."plugins".DS."content".DS."jetestimonial".DS."pagination.php");

			$pageNav   				= new JEPagination( $total, $limitstart, $limit );

			/*if($show_pagination_jextn){
				$limit 			= $pagination_limit;
			}else{

				$limit			= $pageNav->limit;
			}*/
			$limitstart		    = $pageNav->limitstart;

			$order=$this->params->get('order');

			$limittestitems		= 0;
			if(isset($testimonialtext[1]))
			if($testimonialtext[1]=='count'){
				if(isset($testimonialtext[2]))
				if($testimonialtext[2]){
					$limittestitems 		=(int)$testimonialtext[2];
				}
			}

			// function for get testimonials
			$rows     			= $this->getTestimonial($filter_order,$limitstart,$limit,$order,$testimonialtext);

			$pageNav->jelimitstart = $limitstart;
			$testimonials 		= $this->displayTestimonial($rows,$param,$pageNav,$settings,$limittestitems,$total);

		return $testimonials;
	}

	protected function getTotal($filter,$testimonialtext)
	{
		$where = array();

		$where[]    = 's.published = 1';   // while published

		//Check Category or Testimonial from the {testimonial}
		if(isset($testimonialtext[1]))
		if($testimonialtext[1]=='c'){
			if(isset($testimonialtext[2]))
			if($testimonialtext[2]!= null){

				$aryText 					= explode(",",$testimonialtext[2]);
				foreach($aryText as $key => $value)
			        $aryText[$key]			= (int)$value;
				$testimonialtext[2]			= implode(",",$aryText);
				$where[]    				= 'catid IN ('.$testimonialtext[2].')';
			}
		}
		if(isset($testimonialtext[1]))
		if($testimonialtext[1]=='t'){
			if(isset($testimonialtext[2]))
			if($testimonialtext[2]!= null){
				$aryText 					= explode(",",$testimonialtext[2]);
				foreach($aryText as $key => $value)
			        $aryText[$key] 			= (int)$value;
				$testimonialtext[2] 			= implode(",",$aryText);
				$where[]    				= 'id IN ('.$testimonialtext[2].')';
			}
		}

		$limittestitems 						= 0;
		if(isset($testimonialtext[1]))
		if($testimonialtext[1]=='count'){
			if(isset($testimonialtext[2]))
			if($testimonialtext[2]){
				$limittestitems 				= (int)$testimonialtext[2];
				if(isset($testimonialtext[3]))
				if($testimonialtext[3]=='c'){
					if(isset($testimonialtext[4]))
					if($testimonialtext[4]!= null){
						$aryText 			= explode(",",$testimonialtext[4]);
						foreach($aryText as $key => $value)
					        $aryText[$key] 	= (int)$value;
						$testimonialtext[4] 	= implode(",",$aryText);
						$where[]    		= 'id IN ('.$testimonialtext[4].')';
					}
				}
			}
		}


		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';

		// get the total number of records
		$db    = JFactory::getDBO();
		$query = 'SELECT count(*) FROM #__jetestimonial_testimonials AS s'
			. $where
			;

		if($limittestitems)
			$query .= ' limit '.$limittestitems;

		$db->setQuery( $query );
		if (!$db->query()) {
			echo $db->getErrorMsg();
		}

		$total = $db->loadResult();

		return $total;
	}

	protected function getSettings()
	{
			$db     = JFactory::getDBO();
			$query	= $db->getQuery(true);
			$query->select('*');
			$query->from('`#__jetestimonial_settings`');
			$db->setQuery($query);
			$settings		= $db->loadObject();

		return $settings;
	}

	protected function getTestimonial($filter_order,$limitstart,$limit,$order,$testimonialtext)
	{
			$orderby	= $filter_order ;

			$db    = JFactory::getDBO();
			$query		= $db->getQuery(true);
			$query->select('s.*');
			$query->from('#__jetestimonial_testimonials As s');
			$query->where('s.published = 1');

			//Check Category or Testimonial from the {testimonial}
			if(isset($testimonialtext[1]))
			if($testimonialtext[1]=='c'){
				if(isset($testimonialtext[2]))
				if($testimonialtext[2]!= null){
					$aryText 					= explode(",",$testimonialtext[2]);
					foreach($aryText as $key => $value)
				        $aryText[$key] 			= (int)$value;
					$testimonialtext[2] 			= implode(",",$aryText);
					$query->where( 's.catid IN ('.$testimonialtext[2].')');
				}
			}
			if(isset($testimonialtext[1]))
			if($testimonialtext[1]=='t'){
				if(isset($testimonialtext[2]))
				if($testimonialtext[2]!= null){
					$aryText 					= explode(",",$testimonialtext[2]);
					foreach($aryText as $key => $value)
				        $aryText[$key] 			= (int)$value;
					$testimonialtext[2] 			= implode(",",$aryText);
					$query->where( 'id IN ('.$testimonialtext[2].')');
				}
			}
			$limittestitems 						= 0;
			if(isset($testimonialtext[1]))
			if($testimonialtext[1]=='count'){
				if(isset($testimonialtext[2]))
				if($testimonialtext[2]){
					$limittestitems 				= (int)$testimonialtext[2];
					if(isset($testimonialtext[3]))
					if($testimonialtext[3]=='c'){
						if(isset($testimonialtext[4]))
						if($testimonialtext[4]!= null){
							$aryText 			= explode(",",$testimonialtext[4]);
							foreach($aryText as $key => $value)
						        $aryText[$key] 	= (int)$value;
							$testimonialtext[4] 	= implode(",",$aryText);
							$query->where( 's.catid IN ('.$testimonialtext[4].')');
						}
					}
				}
			}


			$query->order($orderby.' '.$order);

			if($limittestitems)
				$db->setQuery($query,0, $limittestitems);
			else
				$db->setQuery($query,$limitstart, $limit);


			$row		= $db->loadObjectList();

			return $row;
	}

	protected function displayTestimonial($rows,$param,$pageNav,$settings,$limittestitems,$total)
	{

		$path 		= JURI::root();
		$doc        = JFactory::getDocument();
		$css   	    = JURI::base().'components/com_jetestimonial/assets/css/style.css';
		$style1     = 'http://fonts.googleapis.com/css?family=OFL+Sorts+Mill+Goudy+TT';
		$style2     = 'http://fonts.googleapis.com/css?family=Tangerine:regular,bold';
		$style3     = 'http://fonts.googleapis.com/css?family=Inconsolata';
		$shadowbox  = JURI::base().'components/com_jetestimonial/assets/js/shadowbox.js';
		$cssshadow  = JURI::base().'components/com_jetestimonial/assets/css/shadowbox.css';
		JHTML::_('behavior.modal');
		$imagepath = "administrator/components/com_jetestimonial/assets/images/noimage/noimage.png";
		$noimage= $path.$imagepath;
		//echo $noimage; exit;

		$doc->addStyleSheet($css);
		$doc->addStyleSheet($style1);
		$doc->addStyleSheet($style2);
		$doc->addStyleSheet($style3);
		$doc->addStyleSheet($cssshadow);

		$uri 	= JFactory::getURI();
		$action = $uri->toString();

		if( $param->get('show_shadowbox',1) )
			$relation = "rel='shadowbox'";
		else
			$relation = '';

			$testimonial ='';
			echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"$shadowbox\"></script>";
			echo "<script type=\"text/javascript\">
						Shadowbox.init();
				 </script>";
			$testimonial.= "<form action=\"$action\" method=\"post\" name=\"adminForm\">";

			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++)
			{
				$row = &$rows[$i];

				$todaydate=date('Y-m-d');
				$releasedate=$row->releasedate;
				if( $releasedate <= $todaydate)
				{


				$link 		= JRoute::_( 'index.php?option=com_jetestimonial&task=details&cid[]='. $row->id );

				if ($settings->theme == '2' || $settings->theme == '6' || $settings->theme == '7') :
					if($this->checkNum($i) === true) :
						$this->style = 'left';
					else :
						$this->style = 'right';
					endif ;
				elseif ($settings->theme == '3') :
					$this->style = 'left';
				elseif ($settings->theme == '1' || $settings->theme == '4') :
					$this->style = 'right';
				else:
					$this->style = '';
				endif;

				// *********************  Default Design ***************************************************************************  //

				$testimonial .= "<div id=\"je-testimonials$settings->theme\" class=\"row$k\">";
				$testimonial .= 	"<div id=\"je-testimonial-content\">";


						if($settings->theme == '8' || $settings->theme == '9' || $settings->theme == '10' || $settings->theme == '11' || $settings->theme == '12' || $settings->theme == '13'){

				/*******New design***********/

					$testimonial .=				"<div id=\"je_testimonial_newtemp$settings->theme\">";
					$testimonial .=					"<div>";
					$testimonial .=						"<table class =\"je_testimonial_newtemp_table\">";
					$testimonial .=							"<tbody class=\"je_testimonial_newtemp_tbody\">";
					$testimonial .=								"<tr class=\"je_testimonial_newtemp_tr\">";
					$testimonial .=									"<td class=\"je_testimonial_newtemp_td_tl\">";
																		 if ($settings->theme == '11') :
					$testimonial .=											"<div class=\"je_testimonial_new11lt\"></div>";
																		 endif;
					$testimonial .=									"</td>";
					$testimonial .=									"<td class=\"je_testimonial_newtemp_td_tr\">";
																	 if ($param->get('show_title', 1) && $settings->theme == '10') :
					$testimonial .=											"<div id=\"je-title$settings->theme\"> <div id=\"je-title1\"> <h2>". $row->title . "</h2> </div> </div> ";
																	 endif;
					$testimonial .=									"</td>";
					$testimonial .=									"</tr>";
					$testimonial .=								"<tr class=\"je_testimonial_newtemp_tr\">";
					$testimonial .=									"<td class=\"je_testimonial_newtemp_td_bl\">";
																 if ($settings->theme == '11') :
					$testimonial .=											"<div class=\"je_testimonial_new11bt\">";
																	if ($param->get('show_avatar', 1) && $settings->theme == '11') :
																	if ($param->get('show_avatar', 1) == '1') :
																		$path 		= JURI::root();
																			if($row->avatar_image != ''):
																			$imagepath = "images/jeavatar/$row->avatar_image";
																			else :
																			$imagepath = "administrator/components/com_jetestimonial/assets/images/noimage/noimage.png";
																			endif;
																			else:
																			$imagepath = " ";
																			endif;
					//$testimonial .=											"<img align=\"$this->style\" class=\"je_imagebor_$this->settings->theme\" src\"=\"".$path.$imagepath."\"/>";
					$testimonial .=												'<img align="'.$this->style.'" class="je_imagebor_'.$settings->theme.'" src="'.$path.$imagepath.'"/>';
																 	endif;
					$testimonial .=											"</div>";
																endif;
					$testimonial .=									"</td>";
					$testimonial .=									"<td class=\"je_testimonial_newtemp_td_br\">";
					$testimonial .=										"<div class=\"je_testimonial_newtemp_content_cont\">";
					$testimonial .=											"<div class=\"je_testimonial_newtemp_content_bg$settings->theme\">";
																 		if ($param->get('show_title', 1) && $settings->theme != '10') :
					$testimonial .=												"<div id=\"je-title$settings->theme\"> <div id=\"je-title1\"> <h2>". $row->title . "</h2> </div> </div> ";
																	 	endif;
					$testimonial .=												"<div id=\"je-con\">";
					$testimonial .=													"<div id=\"je-quote$this->style\">";
																		 	if ($param->get('show_avatar', 1) && $settings->theme != '11') :
																				 if ($settings->theme == '12') :
					$testimonial .=																"<table class=\"table_temp12img_table\">";
					$testimonial .=																	"<tbody class=\"table_temp12img_tbody\">";
					$testimonial .=																		"<tr class=\"table_temp12img_tr\">";
					$testimonial .=																			"<td class=\"table_temp12img_tdtl\"></td>";
					$testimonial .=																			"<td class=\"table_temp12img_tdtr\"></td>";
					$testimonial .=																		"</tr>";
					$testimonial .=																		"<tr class=\"table_temp12img_tr\">";
					$testimonial .=																			"<td class=\"table_temp12img_tdbl\"></td>";
					$testimonial .=																			"<td class=\"table_temp12img_tdbr\">";
																							endif;
																							if ($param->get('show_avatar', 1) == '1') :
																								if($row->avatar_image != ''):
																								$imagepath ="images/jeavatar/".$row->avatar_image;
																								else :
																								$imagepath ="administrator/components/com_jetestimonial/assets/images/noimage/noimage.png";
																								endif;
																							else:
																							$imagepath = " ";
																							endif;
					$testimonial .=														'<img align="'.$this->style.'" class="je_imagebor_'.$settings->theme.'" src="'.$path.$imagepath.'"/>';
																								 if ($settings->theme == '12') :

					$testimonial .=																			"</td>";
					$testimonial .=																		"</tr>";
					$testimonial .=																	"<tbody>";
					$testimonial .=																"</table>";
																							 endif;
																					 endif;
					$testimonial .=													 $row->description;
					$testimonial .=													"</div>";
					$testimonial .=												"</div>";
					$testimonial .=										"<p id=\"style".$settings->theme."para\" align=\"$this->style\">";
																		 if($row->video != '' && $param->get('show_video', 1)){
																		 	$video1="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=.$row->id;";
																		 	$noimage="components/com_jetestimonial/assets/images/achromicgrey-btn.png";
					$testimonial .=												"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"style8play\" class=\"modal\" href=\"$video1\"> <img src=\"$noimage\" alt=\"no\" id=\"buttonimg5\"/></a>";
																		   }

																		if($row->lvideo != '' && $param->get('show_video', 1)){
																			$video2="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=.$row->id&lvideo=1";
																			$noimage="components/com_jetestimonial/assets/images/achromicgrey-btn.png";
					$testimonial .=												"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"style8play\" class=\"modal\" href=\"$video2\"><img src=\"$noimage\" alt=\"no\" id=\"buttonimg5\"/></a>";
																		 	}

																		if($row->laudio != '' && $param->get('show_audio', 1)){
																		 	$video3="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=.$row->id&laudio=1";
																		 	$noimage="components/com_jetestimonial/assets/images/au_achromicgrey-btn.png";
					$testimonial .=												"<a rel='{handler: \"iframe\",size:{x:275,y:45}}'  id=\"style8play\" class=\"modal\" href=\"$video3\"><img src=\"$noimage\" alt=\"no\" id=\"buttonimg5\"/></a>";
																		 	}
					$testimonial .=												"</p>";
																	 	if($settings->theme == '11'){
					$testimonial .=												"<div style=\"clear:both;\"></div>";
																	 	}
					$testimonial .=												"<div id=\"je-audetails\">";
																	 	if ($param->get('show_clientname', 1)) :
					$testimonial .=												"<span id=\"je-author\"> $row->name</span> <br/>";
																		 endif;
																	 	if ($param->get('show_email', 1) && $row->email !='') :
					$testimonial .=												"<span id=\"je-email\"> $row->email </span> <br/>";
																		endif;
																	 	if ($param->get('show_company', 1) && $row->companyname !='') :
					$testimonial .=												"<span id=\"je-companyname\"> $row->companyname </span> <br/>";
																		endif;
																		if ($param->get('show_city', 1) && $row->city !='') :
					$testimonial .=												"<span id=\"je-location\"> $row->city </span><br/>";
																	 	endif;
																 		if ($param->get('show_state', 1) && $row->state !='') :
					$testimonial .=												"<span id=\"je-location\"> $row->state </span><br/>";
																	 	endif;
																		if ($param->get('show_location', 1) && $row->country !='') :
					$testimonial .=												"<span id=\"je-location\"> $row->country </span><br/>";
																	 	endif;
																		$posted_dates 		 = $row->posted_date."<br/>";
																		$date 				 = explode(" ",$posted_dates);
																		$posted_date 		 = $date[0];
																		$posted_date		 = explode("-",$posted_date);
																		if ($param->get('show_date_format_je', 1)){
																			$posted_date		 = $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
																		}else{
																			$posted_date		 = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
																		}
																		if ($param->get('show_posted_date', 1) && $row->posted_date !='') :
					$testimonial .=												"<span id=\"je-posted-date\">".JText::_( 'JE_COMPONENT_POSTED_DATE' ). $posted_date . "</span><br/>";
																		endif;
																		$release_dates 		 = $row->releasedate;
																		$date 				 = explode(" ",$release_dates);
																		$release_date 		 = $date[0];
																		$release_date		 = explode("-",$release_date);
																		if ($param->get('show_date_format_je', 1)){

																		$release_date		 = $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
																		}else{
																		$release_date		 = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
																		}
																		if ($param->get('show_release_date', 1) && $row->releasedate !='') :
					$testimonial .=												"<span id=\"je-release_date\">". JText::_( 'JE_COMPONENT_RELEASE_DATE' ) . $release_date ."</span><br/>";
																		endif;
																		if ($param->get('show_website', 1) && $row->website != '') :
					$testimonial .=												"<span id=\"je-url\"> <a $relation href=\"$row->website\" title=\"$row->website\" target=\"_blank\">$row->website</a></span>";
																		endif;
					$testimonial .=												"</div>";
					$testimonial .=												"<div style=\"clear:both;\"></div>";
					$testimonial .=											"</div>";
					$testimonial .=										"</div>";
					$testimonial .=									"</td>";
					$testimonial .=								"</tr>";
					$testimonial .=							"</tbody>";
					$testimonial .=						"</table>";
					$testimonial .=					"</div>";
					$testimonial .=				"</div>";
					$testimonial .=				"</div>";
					$testimonial .=				"</div>";

} else {
//################################################################ New inner design Ends##################################################################33333333//

				// Inner Design.
				$testimonial .=			"<div id=\"style$settings->theme\" >";
				$testimonial .=				"<div id=\"style$settings->theme\1\"> <div id=\"style$settings->theme\11\"></div></div>";
				$testimonial .=					"<div id=\"style$settings->theme-inner\">";
				$testimonial .=						"<div id=\"style$settings->theme-inner1\">";
			 	$testimonial .=							"<div id=\"style$settings->theme-inner2\">";
				$testimonial .=								"<div id=\"style$settings->theme-inner3\">";

												 if ($param->get('show_title',1) && $settings->theme == '6') :
				$testimonial .=								  		"<div id=\"je-title\"> <div id=\"je-title1\"> <h2>". $row->title . "</h2> </div> </div> ";
											  	 endif;

												 if ($settings->theme == '5') :
			 	$testimonial .=											"<div id=\"je-head\"> <h1>". JText::_( 'JE_TESTIMONIALS' )." </h1> </div>";
				$testimonial .=												"<div id=\"je-con\">";
				$testimonial .=													"<div id=\"je-quote\">";
				$testimonial .=														"<table width=\"100%\">
																						<tr>
																							<td width=\"85%\">
																								<div id=\"je-audetails\">";
																								 if ($param->get('show_clientname',1)) :
				$testimonial .=																		"<span id=\"je-author\"> $row->name </span> <br/>";
																								 endif;
																				if ($param->get('show_company',1) && $row->companyname !='') :
				$testimonial .=																		"<span id=\"je-company\"> $row->companyname </span> <br/>";
																				endif;
																				 if ($param->get('show_email',1) && $row->email !='') :
				$testimonial .=																		"<span id=\"je-email\"> $row->email </span> <br/> ";
																				 endif;
																				if ($param->get('show_city', 1) && $row->city !='') :
				$testimonial .=														"<span id=\"je-location\"> $row->city </span><br/>";
																				endif;
																				if ($param->get('show_state', 1) && $row->state !='') :
				$testimonial .=														"<span id=\"je-location\"> $row->state </span><br/>";
																				endif;
																				if ($param->get('show_location', 1) && $row->country !='') :
				$testimonial .=														"<span id=\"je-location\"> $row->country </span><br/>";
																										endif;
																				$posted_dates 		 = $row->posted_date."<br/>";
																				$date 				 = explode(" ",$posted_dates);
																				$posted_date 		 = $date[0];
																				$posted_date		 = explode("-",$posted_date);
																				if ($param->get('show_date_format_je', 1)){
																					$posted_date		 = $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
																				}else{
																					$posted_date		 = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
																				}
																				if ($param->get('show_posted_date', 1) && $row->posted_date !='') :
				$testimonial .=														"<span id=\"je-posted-date\">".JText::_( 'JE_COMPONENT_POSTED_DATE' ). $posted_date . "</span><br/>";
																				endif;
																				$release_dates 		 = $row->releasedate;
																				$date 				 = explode(" ",$release_dates);
																				$release_date 		 = $date[0];
																				$release_date		 = explode("-",$release_date);
																				if ($param->get('show_date_format_je', 1)){
																				$release_date		 = $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
																				}else{
																				$release_date		 = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
																				}
																				if ($param->get('show_release_date', 1) && $row->releasedate !='') :
				$testimonial .=														"<span id=\"je-release_date\">". JText::_( 'JE_COMPONENT_RELEASE_DATE' ) . $release_date ."</span><br/>";
																					endif;
																				if ($param->get('show_website', 1) && $row->website != '') :
				$testimonial .=														"<span id=\"je-url\"> <a $relation href=\"$row->website\" title=\"$row->website\" target=\"_blank\">$row->website</a></span>";
																				endif;
				$testimonial .=																	"</div>";
			 	$testimonial .=																"</td>";

																				if ($param->get('show_avatar', 1) == '1') :
																					if($row->avatar_image != ''):
																						$imagepath = "images/jeavatar/$row->avatar_image";
																					else :
																						$imagepath = "administrator/components/com_jetestimonial/assets/images/noimage/noimage.png";
																					endif;
																				else:
																					$imagepath = " ";
																				endif;
				$testimonial .=																"<td width=\"15%\" align=\"center\">";
				$testimonial .=																	"<img src=\"$imagepath\"/>";
				$testimonial .=	 															"</td>";
				$testimonial .=														  "</tr>";
				$testimonial .=													   "</table>";
				$testimonial .=												"</div>";
				$testimonial .=												"<div>";
																				 if($settings->theme == '5') :
																				 	$btnpath1 = $path."components/com_jetestimonial/assets/images/achromicgrey-btn.png";
																				 	$audiobtnpath1 =$path. "components/com_jetestimonial/assets/images/au_achromicgrey-btn.png";
																				 	$refpath1 = "index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id";
																				 if($row->video != ''){
				$testimonial .=												 	"<a rel='{handler: \"iframe\",size:{x:560,y:365}}' id=\"style5play\" frameborder=\"0px\" class=\"modal\" href=\"$refpath1\"><img src=\"$btnpath1\" alt=\"no\" /></a>";
																				}
																				if($row->lvideo != ''){
				$testimonial .=												 	"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"style6play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&lvideo=1\"><img src=\"$btnpath1\" alt=\"no\" id=\"buttonimg5\"/></a>";
																				}
																				if($row->laudio != ''){
				$testimonial .=												 	"<a rel='{handler: \"iframe\",size:{x:275,y:45}}'  id=\"style6play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&laudio=1\"><img style=\"margin-right: 5px;\"src=\"$audiobtnpath1\" alt=\"no\" id=\"buttonimg5\"/></a>";
																				}
																				endif;
				$testimonial .=												"</div>";



				$testimonial .=											"<div id=\"je-titlecon\">";
																			if ($param->get('show_title',1)) :
				$testimonial .=									  				"<div id=\"je-title\"> <h2> $row->title </h2> </div>";
													  						endif;
				$testimonial .=													$row->description;
				$testimonial .=												"</div>";
				$testimonial .=											"</div>";



												 else :
												 if ($settings->theme == '1') :

												 		$imagepath = "images/jeavatar/$row->avatar_image";
				$testimonial .=											"<div id=\"je-con\">";
															if ($param->get('show_avatar', 1) == '1') :
																if($row->avatar_image != ''):
																	$imagepath = "images/jeavatar/$row->avatar_image";
																else :
																	$imagepath = "administrator/components/com_jetestimonial/assets/images/noimage/noimage.png";
																endif;
															else:
																$imagepath = " ";
															endif;
			    $testimonial .=		                  			"<img id=\"avatar\" align=\"$this->style\" width=\"75px\" height=\"75px\" src=\"$imagepath\" />";
				$testimonial .=										"<div id=\"je-quote\">";
															if ($param->get('show_title',1)) :
				$testimonial .=														"<div id=\"je-head\"> <h1>". JText::_( 'JE_TESTIMONIALS' ). " </h1> </div>";
				$testimonial .=													  	"<div id=\"je-title\"> <h2> ".$row->title." </h2> </div>";
															endif;
				$testimonial .=														$row->description;

				$testimonial .=												"</div>";
				$testimonial .=											"</div>";
												 else :
													if ($settings->theme == '3') :
				$testimonial .=											"<div id=\"je-head\"> <h1>". JText::_( 'JE_TESTIMONIALS3' ) ." </h1> </div>";
													endif;
													if ($settings->theme == '4') :
				$testimonial .=											"<div id=\"je-head\" style=\"position : absolute;\"> <h1> ".JText::_( 'JE_TESTIMONIALS' )." </h1> </div>";
													endif;
													if ($param->get('show_title',1) && $settings->theme != '6') :
				$testimonial .=									  		"<div id=\"je-title\"> <h2> $row->title </h2> </div>";
													endif;
				$testimonial .=											"<div id=\"je-con\">";
				$testimonial .=												"<div id=\"je-quote$this->style\">";
																if ($param->get('show_avatar', 1) == '1') :
																	if($row->avatar_image != ''):
																		$imagepath = "images/jeavatar/$row->avatar_image";
																	else :
																		$imagepath = $path."administrator/components/com_jetestimonial/assets/images/noimage/noimage.png";
																	endif;
																else:
																	$imagepath = " ";
																endif;
				$testimonial .=												"<img align=\"$this->style\" src=\"$imagepath\" />";
				$testimonial .=														$row->description;
				$testimonial .=												"</div>";
				$testimonial .=											"</div>";
												endif;
				$testimonial .=										"<div id=\"je-audetails\">";
														if ($param->get('show_clientname',1)) :
				$testimonial .=										"<span id=\"je-author\"> $row->name  </span> <br/> ";
														endif;
														if ($param->get('show_company',1) && $row->companyname !='') :
				$testimonial .=										"<span id=\"je-company\"> $row->companyname </span> <br/>";
														endif;
														if ($param->get('show_email',1) && $row->email !='')  :
				$testimonial .=										"<span id=\"je-email\"> $row->email </span> <br/>";
														endif;
														if ($param->get('show_city', 1) && $row->city !='') :
				$testimonial .=										"<span id=\"je-location\"> $row->city </span><br/>";
														endif;
														if ($param->get('show_state', 1) && $row->state !='') :
				$testimonial .=										"<span id=\"je-location\"> $row->state </span><br/>";
														endif;
														if ($param->get('show_location', 1) && $row->country !='') :
				$testimonial .=										"<span id=\"je-location\"> $row->country </span><br/>";
														endif;
														$posted_dates 		 = $row->posted_date."<br/>";
														$date 				 = explode(" ",$posted_dates);
														$posted_date 		 = $date[0];
														$posted_date		 = explode("-",$posted_date);
														if ($param->get('show_date_format_je', 1)){
															$posted_date		 = $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
														}else{
															$posted_date		 = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
														}
														if ($param->get('show_posted_date', 1) && $row->posted_date !='') :
				$testimonial .=										"<span id=\"je-posted-date\">".JText::_( 'JE_COMPONENT_POSTED_DATE' ). $posted_date . "</span><br/>";
														endif;
														$release_dates 		 = $row->releasedate;
														$date 				 = explode(" ",$release_dates);
														$release_date 		 = $date[0];
														$release_date		 = explode("-",$release_date);
														if ($param->get('show_date_format_je', 1)){
														$release_date		 = $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
														}else{
														$release_date		 = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
														}
														if ($param->get('show_release_date', 1) && $row->releasedate !='') :
				$testimonial .=										"<span id=\"je-release_date\">". JText::_( 'JE_COMPONENT_RELEASE_DATE' ) . $release_date ."</span><br/>";
														endif;
														if ($param->get('show_website', 1) && $row->website != '') :
				$testimonial .=										"<span id=\"je-url\"> <a $relation href=\"$row->website\" title=\"$row->website\" target=\"_blank\">$row->website</a></span>";
														endif;
				$testimonial .=							"</div>";

												 endif;
				$testimonial .=										"<div class=\"clr\"></div>";


																	if($settings->theme == '4' || $settings->theme == '3'|| $settings->theme == '2'):
				$testimonial .=											"<p id=\"style6para\" align=\"$this->style\">";
																		 	$btnpath2=$path."components/com_jetestimonial/assets/images/loyalty-btn.png";
																		 	$audiopath2=$path."components/com_jetestimonial/assets/images/au_loyalty-btn.png";
																		 	$refpath2="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id";
																		 	$video1="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&lvideo=1";
																		 if($row->video!='') :
				$testimonial .=											"<a rel='{handler: \"iframe\",size:{x:560,y:365}}' id=\"style234play\" class=\"modal\" href=\"$refpath2\"><img src=\"$btnpath2\" alt=\"no\" /></a>";
																		endif;
																		if($row->lvideo!=''){
				$testimonial .=											"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"style6play\" class=\"modal\" href=\"$video1\">";

				$testimonial .=												'<img style="margin-right: 5px;" src="'.$btnpath2.'" alt="nsdfgfo" id="buttonimg"/>';

				$testimonial .=	 										"</a>";
																		}
																		if($row->laudio!=''){
				$testimonial .=											"<a rel='{handler: \"iframe\",size:{x:275,y:45}}'  id=\"style6play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&laudio=1\"><img src=\"$audiopath2\" alt=\"no\" id=\"buttonimg\"/></a>";
																		}
				$testimonial .=											"</p>";
																	else:
																	 if($settings->theme == '6'):
				$testimonial .=											"<p id=\"style6para\" align=\"$this->style\">";
																			$btnpath3=$path."components/com_jetestimonial/assets/images/sunshine-btn.png";
																		 	$audiobtnpath3=$path."components/com_jetestimonial/assets/images/au_sunshine-btn.png";
																		 	$refpath3="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id";
																		 	if($row->video!='') :
				$testimonial .=												"<a rel='{handler: \"iframe\",size:{x:560,y:365}}' id=\"style6play\" class=\"modal\" href=\"$refpath3\"><img src=\"$btnpath3\" alt=\"no\" /></a>";
																			endif;
																			if($row->lvideo!=''){
				$testimonial .=													"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"style6play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&lvideo=1\"><img style=\"margin-right:5px;\" src=\"$btnpath3\" alt=\"no12\" id=\"buttonimg\"/></a>";
																			}
																			if($row->laudio!=''){
				$testimonial .=													"<a rel='{handler: \"iframe\",size:{x:275,y:45}}'  id=\"style6play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&laudio=1\"><img style=\"margin-right:5px;\" src=\"$audiobtnpath3\" alt=\"nosfg1\" id=\"buttonimg\"/></a>";
																			}
				$testimonial .=											 "</p>";
																	 	endif;
																	endif;

				$testimonial .=										 "<div>";
																		if($settings->theme == '1'):
																		$btnpath4=$path."components/com_jetestimonial/assets/images/rhymblue-btn.png";
																		$audiobtnpath4=$path."components/com_jetestimonial/assets/images/au_rhymblue-btn.png";
																		$refpath4="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id";
																		if($row->video != ''){
				$testimonial .=											"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"play\" class=\"modal\" href=\"$refpath4\"><img src=\"$btnpath4\" alt=\"no\" /></a>";
																		}
																		if($row->lvideo != ''){
				$testimonial .=											"<a rel='{handler: \"iframe\",size:{x:560,y:365}}'  id=\"play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&lvideo=1\"><img src=\"$btnpath4\" alt=\"no\" id=\"buttonimg\"/></a>";
																		}
																		if($row->laudio != ''){
				$testimonial .=											"<a rel='{handler: \"iframe\",size:{x:275,y:45}}'  id=\"play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&laudio=1\"><img style=\"margin-left:5px;\" src=\"$audiobtnpath4\" alt=\"no\" id=\"buttonimgs\"/></a>";
																		}
																		endif;
				$testimonial .=										"</div>";

				$testimonial .=										"<br style=\"clear : both;\"/>";
				$testimonial .=										"<br style=\"clear : both;\"/>";
				$testimonial .=								"</div>";

				$testimonial .=								"<p align=\"$this->style\">";
															if($settings->theme == '7'):
																$btnpath5=$path."components/com_jetestimonial/assets/images/achromicgrey-btn.png";
																$audiobtnpath5=$path."components/com_jetestimonial/assets/images/au_achromicgrey-btn.png";
																$refpath5="index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id";
																if($row->video!=''){
				$testimonial .=										"<a rel='{handler: \"iframe\",size:{x:560,y:365}}' id=\"style7play\" class=\"modal\" href=\"$refpath5\"><img src=\"$btnpath5\" alt=\"no\"/></a>";
																}
																if($row->lvideo!=''){
				$testimonial .=										"<a rel='{handler: \"iframe\",size:{x:560,y:365}}' id=\"style234play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&lvideo=1\"><img src=\"$btnpath5\" alt=\"no\" id=\"buttonimg\"/></a>";
																}
																if($row->laudio != ''){
				$testimonial .=									"<a rel='{handler: \"iframe\",size:{x:275,y:45}}'  id=\"play\" class=\"modal\" href=\"$path/index.php?option=com_jetestimonial&view=testimonials&layout=default_video&tmpl=component&id=$row->id&laudio=1\"><img style=\"margin-left:5px;\" src=\"$audiobtnpath5\" alt=\"no\" id=\"buttonimgs\"/></a>";
																}
															endif;
				$testimonial .=								"</p>";
				$testimonial .=							"</div>";
				$testimonial .=						"</div>";
				$testimonial .=					"</div>";
				$testimonial .=				"<div id=\"style$settings->theme\2\"><div id=\"style$settings->theme\22\"></div></div>";
				$testimonial .=			"</div>";
				//			<!-- inner design end -->
				$testimonial .=		"</div>";
				$testimonial .=	"</div>";

					// ********************************  Default design End..  ************************************************************************  ///
				}
			}
					$k = 1 - $k;
				}
			//<!-- Pagination code start -->
				/*pagination jextn*/
				$settings					= $this->getSettings();
				$show_pagination_jextn		= $settings->show_pagination_jextn;

				if($show_pagination_jextn){

						$testimonial .= "<div class=\"pagination\">";
						$testimonial .= "<div id=\"jetestimonial-paginationarea\">";
						$testimonial .=	 	$pageNav->getListFooter();
						$testimonial .=	 "<input type=\"hidden\" name=\"jelimitstart\" value=\"$pageNav->jelimitstart\">";
						$testimonial .= "</div>";
						$testimonial .= "</div>";

				}

				//<!-- Pagination code End -->

    			$testimonial .= "</form>";

		 return $testimonial;
	}
	protected function checkNum($num)
	{
	  return ($num%2) ? true : false;
	}
}

