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
<div class="testimonials">
        <div id="tcb-testimonial-carousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
            	<?php
		for ($i=0, $n=count( $testimonials ); $i < $n; $i++) {
			$row = &$testimonials[$i]; ?>
                <li data-target="#tcb-testimonial-carousel" data-slide-to="<?php echo $i;?>" class=""></li>
                <?php }?>
                
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
            	

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
				$country 		= "<div class='te-count'>".$row->country."</div>";
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
				$city 			= "<div class='te-city'>".$row->city."</div>";
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
                <div class="item">
                    <div class="row">
                        <div class="col-xs-12">
                           <figure class="clearfix">
                               <div class="col-md-3 col-sm-3 img-name">
                               	<img class="img-responsive media-object" src="<?php echo $avatar; ?>">
                               	<?php echo $name; ?> 
                               	<div><?php  echo $row->city; echo ", " ;echo $row->country;?></div>                               	
                               </div>
                               <div class="col-md-9 col-sm-9">
                                    <figcaption class="caption">
                                       
                                        <sup><img src="<?php echo JURI::base()?>modules/mod_jetestimonial/assets/images/quote1.png"></sup>
										<p class="cap"><?php echo $des ?>
										<sub><img src="<?php echo JURI::base()?>modules/mod_jetestimonial/assets/images/quote2.png"></sub></p>
																	
                                    </figcaption>
                               </div>
                           </figure>
                        </div>
                    </div>
                </div>

<?php }
endif;
?>

</div>
</div>
</div>
<script>
jQuery(document).ready(function(){
	jQuery(".carousel-inner").children('.item:nth-child(1)').addClass("active");
	jQuery(".carousel-indicators").children('li:nth-child(1)').addClass("active");
	
});
</script>

    