<?php
/**
 * jeTestimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
$path 	= JURI::root();
$itemid  	= JRequest::getVar('Itemid', 0, '', 'int');
$read   = '';

if (count($testimonials) > 0) :

/*Add & All Testimonial link*/

if($add_all_testimonial_postion==0){
?>
<div class="add_all">
<?php if($display_add_testimonial_link==1){ ?>
 	<div align="<?php echo $add_all_link_position;?>" id="add_testimonial_link">
		<a id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&amp;view=form&amp;layout=edit&amp;Itemid=".$itemid, false); ?> "><?php echo JText::_( 'JE_ADDTESTIMONIALS' ); ?></a>
	</div>
<?php }  if($display_all_testimonial_link==1){ ?>
	<div align="<?php echo $add_all_link_position;?>" id="all_testimonial_link">
		<a  id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&amp;view=testimonials");?>"><?php echo JText::_( 'JE_ALL_TESTIMONIAL' ); ?></a>
	</div>
<?php }?>
</div>
<?php }
?>
<script language="JavaScript1.2">
	// The details from the module backend..
	var je_direction_<?php echo $je_module_id; ?>       = "<?php echo $je_direction; ?>"
	var scrollerwidth_<?php echo $je_module_id; ?>      = "<?php echo trim ( $params->get ( 'width' ) ); ?>%"
	var scrollerheight_<?php echo $je_module_id; ?>     = "<?php echo trim ( $params->get ( 'height' ) ); ?>px"
	var scrollerbgcolor_<?php echo $je_module_id; ?>    = '<?php echo trim ( $params->get ( 'bgcolor' ) ); ?>'
	var pausebetweenimages_<?php echo $je_module_id; ?> = parseInt('<?php echo trim ( $params->get ( 'speed' ) ); ?>')
	var slideimages_<?php echo $je_module_id; ?>        = new Array()
		<?php
		for ($i=0, $n=count( $testimonials ); $i < $n; $i++) {
			$row = &$testimonials[$i];

			if ($row->avatar_image == '') {
				$avatar = "components/com_jetestimonial/assets/images/noimage/noimage.png";
			} else{
				$avatar = "images/jeavatar/".$row->avatar_image;
			}
			$row->description=strip_tags($row->description);

			$des 	 = str_replace("\r\n","",$row->description);
			$des 	 = str_replace('"','\"',$des);
			$id		 = $row->id;

			if ( $readmore == 1 ) {
				if (strlen($des) > $limit) {
					$des  	= (substr($des, 0, $limit));
					$link 	= JRoute::_('index.php?option=com_jetestimonial&view=testimonials&id='.$id);
					$read 	= "<div style='text-align : $readmore_align' id='je-readmore'> <a href='$link' >". $readmore_text ."</a></div>";
				}
			} else {
				$des = $des;
				$read = '';
			}

			$name	 = $row->name."<br/>";

			$posted_dates 	= $row->posted_date."<br/>";
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
			if($display_posted_date)
				$posted_date 	= '<div>'.JText::_( 'JE_MOD_TESTIMONIAL_POSTED_DATE' ).$posted_date.'</div>';
			else
				$posted_date 	= '';

			if($display_release_date)
				$release_date 	= '<div>'.JText::_( 'JE_MOD_TESTIMONIAL_RELEASE_DATE' ).$release_date.'</div>';
			else
				$release_date 	= '';

			if($display_country)
				$country 		= '<div>'.$row->country.'</div>';
			else
				$country 		= '';
			if($display_email)
				$email	 		= '<div>'.$row->email.'</div>';
			else
				$email 		= '';
			if($display_title)
				$title			= '<div class=\"je-title_mod_testi\"><h4>'.$row->title.'</h4></div>';
			else
				$title 		= '';
			if($display_name)
				$name 			= "<div class='client-name'>".$row->name."</div>";
			else
				$name 		= '';
			if($display_company_name)
				$companyname 	= '<div>'.$row->companyname.'</div>';
			else
				$companyname 		= '';
			if($display_city)
				$city 			= '<div>'.$row->city.'</div>';
			else
				$city 		= '';
			if($display_state)
				$state	 		= '<div>'.$row->state.'</div>';
			else
				$state 		= '';
			if($display_website)
				$website 		= '<div><a href=\"'.$row->website.'\">'.$row->website.'</a></div>';
			else
				$website 		= '';
		?>
			var title_<?php echo $je_module_id; ?> = "<?php echo $title; ?>";
			var desc_<?php echo $je_module_id; ?>  = "<?php echo $des; ?>";
			var loc_<?php echo $je_module_id; ?>   = "<?php echo $name.$email.$companyname.$city.$state.$country.$website.$posted_date.$release_date; ?>";
			var read_<?php echo $je_module_id; ?>  = "<?php echo $read; ?>";
			var avatardisp_<?php echo $je_module_id; ?> = "<?php echo $avatarshow; ?>";
			if(avatardisp_<?php echo $je_module_id; ?> != 0){
			slideimages_<?php echo $je_module_id; ?>[<?php echo $i; ?>]=['<div id="je-module" width="<?php echo trim ( $params->get ( 'width' ) ); ?>%"><div id="je-modcon"><div id="je-modimg"><img src="<?php echo $path.$avatar; ?>"></div><div id="je-description">'+title_<?php echo $je_module_id; ?>+''+ desc_<?php echo $je_module_id; ?> +'</div>'+ read_<?php echo $je_module_id; ?> +'</div><div  width="<?php echo trim ( $params->get ( 'width' ) ); ?>%" id="je-address">'+ loc_<?php echo $je_module_id; ?> +'</div></div>']
			} else{
				slideimages_<?php echo $je_module_id; ?>[<?php echo $i; ?>]=['<div id="je-module" width="<?php echo trim ( $params->get ( 'width' ) ); ?>%"><div id="je-modcon"><div id="je-description">'+ desc_<?php echo $je_module_id; ?> +'</div>'+ read_<?php echo $je_module_id; ?> +'</div><div id="je-address">'+ loc_<?php echo $je_module_id; ?> +'</div></div>']
			}
		<?php
		}
		?>
</script>
<script language="JavaScript1.2">
var ie=document.all
var dom=document.getElementById
if (slideimages_<?php echo $je_module_id; ?>.length > 2)
	incre_<?php echo $je_module_id; ?> = 2
else
	incre_<?php echo $je_module_id; ?> = 0

function jegetdata_<?php echo $je_module_id; ?>(wdiv) {
	switch(je_direction_<?php echo $je_module_id; ?>)
	{
		case "1":
			var jepos = wdiv.style.right;
			var jewh  = wdiv.offsetWidth;
			var jeswh = scrollerwidth_<?php echo $je_module_id; ?>;
		 	break;
		case "2":
			var jepos = wdiv.style.left;
			var jewh  = wdiv.offsetWidth;
			var jeswh = scrollerwidth_<?php echo $je_module_id; ?>;
		 	break;
		case "3":
			var jepos = wdiv.style.bottom;
			var jewh  = wdiv.offsetHeight;
			var jeswh = scrollerheight_<?php echo $je_module_id; ?>;
		 	break;
		case "4":
			var jepos = wdiv.style.top;
			var jewh  = wdiv.offsetHeight;
			var jeswh = scrollerheight_<?php echo $je_module_id; ?>;
		  	break;
		default:
			var jepos = wdiv.style.left;
			var jewh  = wdiv.offsetWidth;
			var jeswh = scrollerwidth_<?php echo $je_module_id; ?>;
			break;
	}
	rdata_<?php echo $je_module_id; ?> = {"jepos":jepos,"jewh":jewh,"jeswh":jeswh};
	return rdata_<?php echo $je_module_id; ?>;
}

function jerotate_<?php echo $je_module_id; ?>(wdiv_<?php echo $je_module_id; ?>,val_<?php echo $je_module_id; ?>) {
	switch(je_direction_<?php echo $je_module_id; ?>)
	{
		case "1":
			wdiv_<?php echo $je_module_id; ?>.style.right  = val_<?php echo $je_module_id; ?>+"px";
		 	break;
		case "2":
			wdiv_<?php echo $je_module_id; ?>.style.left   = val_<?php echo $je_module_id; ?>+"px";
		 	break;
		case "3":
			wdiv_<?php echo $je_module_id; ?>.style.bottom = val_<?php echo $je_module_id; ?>+"px";
		 	break;
		case "4":
			wdiv_<?php echo $je_module_id; ?>.style.top    = val_<?php echo $je_module_id; ?>+"px";
		  	break;
		default:
			wdiv_<?php echo $je_module_id; ?>.style.left   = val_<?php echo $je_module_id; ?>+"px";
			break;
	}
}

function move3_<?php echo $je_module_id; ?>(whichdiv){
	tdiv_<?php echo $je_module_id; ?>       = eval(whichdiv)
	var jedata_<?php echo $je_module_id; ?> = jegetdata_<?php echo $je_module_id; ?>(whichdiv);
	if (parseInt(jedata_<?php echo $je_module_id; ?>.jepos)>0&&parseInt(jedata_<?php echo $je_module_id; ?>.jepos)<=5){
		tdiv_<?php echo $je_module_id; ?>.style.dir = 0+"px"
		jerotate_<?php echo $je_module_id; ?>(tdiv_<?php echo $je_module_id; ?>,0)
		setTimeout("move3_<?php echo $je_module_id; ?>(tdiv_<?php echo $je_module_id; ?>)",pausebetweenimages_<?php echo $je_module_id; ?>)
		setTimeout("move4_<?php echo $je_module_id; ?>(scrollerdiv2_<?php echo $je_module_id; ?>)",pausebetweenimages_<?php echo $je_module_id; ?>)
		return
	}
	if (parseInt(jedata_<?php echo $je_module_id; ?>.jepos)>= jedata_<?php echo $je_module_id; ?>.jewh*-1){
		jerotate_<?php echo $je_module_id; ?>(tdiv_<?php echo $je_module_id; ?>,parseInt(jedata_<?php echo $je_module_id; ?>.jepos)-5)
		setTimeout("move3_<?php echo $je_module_id; ?>(tdiv_<?php echo $je_module_id; ?>)",50)
	}
	else{
		jerotate_<?php echo $je_module_id; ?>(tdiv_<?php echo $je_module_id; ?>,jedata_<?php echo $je_module_id; ?>.jewh)
		tdiv_<?php echo $je_module_id; ?>.innerHTML = slideimages_<?php echo $je_module_id; ?>[incre_<?php echo $je_module_id; ?>]
		if (incre_<?php echo $je_module_id; ?>==slideimages_<?php echo $je_module_id; ?>.length-1)
			incre_<?php echo $je_module_id; ?> = 0
		else
			incre_<?php echo $je_module_id; ?>++
	}
}

function move4_<?php echo $je_module_id; ?>(whichdiv){
	tdiv2_<?php echo $je_module_id; ?>      = eval(whichdiv)
	var jedata_<?php echo $je_module_id; ?> = jegetdata_<?php echo $je_module_id; ?>(whichdiv);
	if (parseInt(jedata_<?php echo $je_module_id; ?>.jepos)>0&&parseInt(jedata_<?php echo $je_module_id; ?>.jepos)<=5){
		jerotate_<?php echo $je_module_id; ?>(tdiv2_<?php echo $je_module_id; ?> ,0)
		setTimeout("move4_<?php echo $je_module_id; ?>(tdiv2_<?php echo $je_module_id; ?>)",pausebetweenimages_<?php echo $je_module_id; ?>)
		setTimeout("move3_<?php echo $je_module_id; ?>(scrollerdiv1_<?php echo $je_module_id; ?>)",pausebetweenimages_<?php echo $je_module_id; ?>)
		return
	}
	if (parseInt(jedata_<?php echo $je_module_id; ?>.jepos)>=jedata_<?php echo $je_module_id; ?>.jewh*-1){
		jerotate_<?php echo $je_module_id; ?>(tdiv2_<?php echo $je_module_id; ?>,parseInt(jedata_<?php echo $je_module_id; ?>.jepos)-5)
		setTimeout("move4_<?php echo $je_module_id; ?>(scrollerdiv2_<?php echo $je_module_id; ?>)",50)
	}
	else {
		jerotate_<?php echo $je_module_id; ?>(tdiv2_<?php echo $je_module_id; ?>,jedata_<?php echo $je_module_id; ?>.jewh)
		tdiv2_<?php echo $je_module_id; ?>.innerHTML=slideimages_<?php echo $je_module_id; ?>[incre_<?php echo $je_module_id; ?>]
		if (incre_<?php echo $je_module_id; ?>==slideimages_<?php echo $je_module_id; ?>.length-1)
			incre_<?php echo $je_module_id; ?> = 0
		else
			incre_<?php echo $je_module_id; ?>++
	}
}

function startscroll_<?php echo $je_module_id; ?>(){
	if (ie||dom){
		scrollerdiv1_<?php echo $je_module_id; ?> = ie ? first2_<?php echo $je_module_id; ?> : document.getElementById("first2_<?php echo $je_module_id; ?>")
		scrollerdiv2_<?php echo $je_module_id; ?> = ie ? second2_<?php echo $je_module_id; ?> : document.getElementById("second2_<?php echo $je_module_id; ?>")
		move3_<?php echo $je_module_id; ?>(scrollerdiv1_<?php echo $je_module_id; ?>)
	}
}

if (window.addEventListener)
	window.addEventListener("load", startscroll_<?php echo $je_module_id; ?>, false)
else if (window.attachEvent)
	window.attachEvent("onload", startscroll_<?php echo $je_module_id; ?>)
else if (ie4||dom||document.layers)
	window.onload=startscroll_<?php echo $je_module_id; ?>

</script>

<script language="JavaScript1.2">
	switch(je_direction_<?php echo $je_module_id; ?>)
	{
		case "1":
			var fstyle_<?php echo $je_module_id; ?> = "right:1px;top:0px;";
			var sstyle_<?php echo $je_module_id; ?> = "right:"+scrollerwidth_<?php echo $je_module_id; ?>+";top:0px;";
		 	break;
		case "2":
			var fstyle_<?php echo $je_module_id; ?> = "left:1px;top:0px;";
			var sstyle_<?php echo $je_module_id; ?> = "left:"+scrollerwidth_<?php echo $je_module_id; ?>+";top:0px;";
		 	break;
		case "3":
			var fstyle_<?php echo $je_module_id; ?> = "bottom:1px;left:0px;";
			var sstyle_<?php echo $je_module_id; ?> = "bottom:"+scrollerheight_<?php echo $je_module_id; ?>+";left:0px;";
		 	break;
		case "4":
			var fstyle_<?php echo $je_module_id; ?> = "top:1px;left:0px;";
			var sstyle_<?php echo $je_module_id; ?> = "top:"+scrollerheight_<?php echo $je_module_id; ?>+";left:0px;";
		  	break;
		default:
			var fstyle_<?php echo $je_module_id; ?> = "left:1px;top:0px;";
			var sstyle_<?php echo $je_module_id; ?> = "left:"+scrollerwidth_<?php echo $je_module_id; ?>+";top:0px;";
			break;
	}

	if (ie||dom){
		document.writeln('<div id="main2" style="position:relative;width:100%;height:'+scrollerheight_<?php echo $je_module_id; ?>+';overflow:hidden;background-color:'+scrollerbgcolor_<?php echo $je_module_id; ?>+'">')
		document.writeln('<div style="position:absolute;width:100%;height:'+scrollerheight_<?php echo $je_module_id; ?>+';clip:rect(0 '+scrollerwidth_<?php echo $je_module_id; ?>+' '+scrollerheight_<?php echo $je_module_id; ?>+' 0);left:0px;top:0px">')
		document.writeln('<div id="first2_<?php echo $je_module_id; ?>" style="position:absolute;width:100%;height:'+scrollerheight_<?php echo $je_module_id; ?>+';'+fstyle_<?php echo $je_module_id; ?>+'">')
		document.write(slideimages_<?php echo $je_module_id; ?>[0])
		document.writeln('</div>')
		document.writeln('<div id="second2_<?php echo $je_module_id; ?>" style="position:absolute;width:100%;height:'+scrollerheight_<?php echo $je_module_id; ?>+';'+sstyle_<?php echo $je_module_id; ?>+'">')
		document.write((slideimages_<?php echo $je_module_id; ?>[1] != undefined && slideimages_<?php echo $je_module_id; ?>[1] != "" ) ? slideimages_<?php echo $je_module_id; ?>[1] : slideimages_<?php echo $je_module_id; ?>[0])
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
	}
</script>
<?php
else:
	echo JText::_('MOD_MES');
endif;
$itemid  	= JRequest::getVar('Itemid', 0, '', 'int');
if (!empty($des)):
if($add_all_testimonial_postion==1){
?>
<div class="add_all">
<?php if($display_add_testimonial_link==1){?>
 	<div align="<?php echo $add_all_link_position;?>" id="add_testimonial_link">
		<a id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=form&layout=edit&Itemid=".$itemid, false); ?> "><?php echo JText::_( 'JE_ADDTESTIMONIALS' ); ?></a>
	</div>
<?php }  if($display_all_testimonial_link==1){?>
	<div align="<?php echo $add_all_link_position;?>" id="all_testimonial_link">
	<a  id="link_jafadar" href="<?php echo JRoute::_("index.php?option=com_jetestimonial&view=testimonials");?>"><?php echo JText::_( 'JE_ALL_TESTIMONIAL' ); ?></a>
	</div>
<?php }?>
</div>
<div style="clear:both;"></div>
<?php }
endif;
?>