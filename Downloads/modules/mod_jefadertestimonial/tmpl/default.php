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
$path 		= JURI::root();
$itemid  	= JRequest::getVar('Itemid', 0, '', 'int');
?>

<?php
if($add_all_testimonial_postion==0){
if($display_add_testimonial_link==1){?>
 	<div align="<?php echo $add_all_link_position;?>" id="adds">
		<a id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=form&layout=edit&Itemid=".$itemid, false); ?> "><?php echo JText::_( 'JE_ADDTESTIMONIALS' ); ?></a>
	</div>
<?php }  if($display_all_testimonial_link==1){?>
	<div align="<?php echo $add_all_link_position;?>" id="all_testimonial">
	<a  id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=testimonials");?>"><?php echo JText::_( 'JE_ALL_TESTIMONIAL' ); ?></a>
	</div>
<?php }
}

	$start_colr	= $params->get ( 'startclor', '255,255,255' );
	$star_colr =explode(',', $start_colr);
	$star_colr_r = $star_colr[0];
	$star_colr_g = $star_colr[1];
	$star_colr_b = $star_colr[2];

	$end_colr	= $params->get ( 'endcolor', '0,0,0' );
	$end_colr   = explode(',', $end_colr);
	$end_colr_r = $end_colr[0];
	$end_colr_g = $end_colr[1];
	$end_colr_b = $end_colr[2];
?>

<script language="JavaScript1.2">
	var trans_width1="<?php echo trim ( $params->get ( 'width' ) ); ?>"
	var trans_height1="<?php echo trim ( $params->get ( 'height' ) ); ?>"
	var pause1=parseInt('<?php echo trim ( $params->get ( 'speed' ) ); ?>')
	var fontstyle1="<?php echo trim ( $params->get ( 'fontstyle' )); ?>"
	var degree1=parseInt('<?php echo trim ( $params->get ( 'degree' ) ); ?>')
	var bgcolor1='<?php echo trim ( $params->get ( 'bgcolor' ) ); ?>'
	var fontsize="<?php echo trim ( $params->get ( 'font_size', '12' ) ); ?>"
	var fontfamily="<?php echo trim ( $params->get ( 'font_family', 'Arial' ) ); ?>"
	var je_fadar_padding="<?php echo trim ( $params->get ( 'je_fadar_padding', '10' ) ); ?>"

	var starfonttcolor_r="<?php echo trim($star_colr_r);?>"
	var starfonttcolor_g="<?php echo trim($star_colr_g);?>"
	var starfonttcolor_b="<?php echo trim($star_colr_b);?>"

	var endfontcolor_r="<?php echo trim($end_colr_r);?>"
	var endfontcolor_g="<?php echo trim($end_colr_g);?>"
	var endfontcolor_b="<?php echo trim($end_colr_b);?>"


	var slideshowcontent1=new Array()
	<?php
	for ($i=0, $n=count( $testimonials ); $i < $n; $i++) {
		$row = &$testimonials[$i];

		$des 	 		= str_replace("\r\n","",$row->description);
		$des 			= str_replace('"','\"',$des);
		$id		 		= $row->id;
		$client	 		= $row->name;
		/*posted date*/
		$posted_dates 	= $row->posted_date.'<br/>';
		$date 			= explode(" ",$posted_dates);
		$posted_date 	= $date[0];
		$posted_date	= explode("-",$posted_date);
		if ($jextn_date_format){
		$posted_date	= $posted_date[2].'-'.$posted_date[1].'-'.$posted_date[0];
		}else{
		$posted_date    = $posted_date[0].'-'.$posted_date[1].'-'.$posted_date[2];
		}
		/*Release date*/
		$release_dates 	= $row->releasedate;
		$date 			= explode(" ",$release_dates);
		$release_date 	= $date[0];
		$release_date	= explode("-",$release_date);
		if ($jextn_date_format){
		$release_date	= $release_date[2].'-'.$release_date[1].'-'.$release_date[0];
		}else{
		$release_date   = $release_date[0].'-'.$release_date[1].'-'.$release_date[2];
		}

		if ( $readmore == 1 ) {
			if (strlen($des) > $limit) {
				$itemid = JRequest::getVar('Itemid', 0, '', 'int');
				$des  	= substr(strip_tags($des), 0, $limit);
				$link 	= JRoute::_( 'index.php?option=com_jetestimonial&view=testimonials&id='. $row->id .'&Itemid='.$itemid );
				$read 	= "<div style='text-align : $readmore_align' id='je-readmore'> <a id='je_readmore_a' href='$link'>". $readmore_text ."</a></div>";
			} else {
				$des = $des;
				$read = '';
			}

		} else {
			$des = $des;
			$read = '';
		}
	?>
		slideshowcontent1[<?php echo $i; ?>]=["<?php if ( $readmore == 1 ) {echo $des."...";}else{ echo $des;} ?>",
		"<?php echo $client; ?>",
		"<?php if($display_posted_date==1){ echo  JText::_( 'JE_MOD_TESTIMONIAL_POSTED_DATE' ) .$posted_date .'<br/>';}else{echo $posted_date = '';} ?>",
		"<?php if($display_release_date==1){ echo JText::_( 'JE_MOD_TESTIMONIAL_RELEASE_DATE' ) .$release_date;}else{echo $release_date = '';} ?>",
		"<?php echo $read; ?>"]
	<?php
	}
	?>
</script>

<script type="text/javascript" src="<?php echo $path; ?>modules/mod_jefadertestimonial/assets/script/default.js" language="JavaScript1.2"></script>

<?php
$itemid  	= JRequest::getVar('Itemid', 0, '', 'int');
if (!empty($des)):
if($add_all_testimonial_postion==1){
if($display_add_testimonial_link==1){?>
 	<div align="<?php echo $add_all_link_position;?>" id="adds">
		<a id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=form&layout=edit&Itemid=".$itemid, false); ?> "><?php echo JText::_( 'JE_ADDTESTIMONIALS' ); ?></a>
	</div>
<?php }  if($display_all_testimonial_link==1){?>
	<div align="<?php echo $add_all_link_position;?>" id="all_testimonial">
	<a  id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=testimonials");?>"><?php echo JText::_( 'JE_ALL_TESTIMONIAL' ); ?></a>
	</div>
<?php
 }
}
endif;
?>

<div style="clear:both;"></div>