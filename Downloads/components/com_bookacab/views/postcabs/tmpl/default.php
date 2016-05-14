<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Bookacab
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_bookacab');
$canEdit    = $user->authorise('core.edit', 'com_bookacab');
$canCheckin = $user->authorise('core.manage', 'com_bookacab');
$canChange  = $user->authorise('core.edit.state', 'com_bookacab');
$canDelete  = $user->authorise('core.delete', 'com_bookacab');

$cabme_date = $this->getState('filter.cabme_date');
$cabme_time = $this->getState('filter.cabme_time');


$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('min(a.totalfare) AS min_fare,max(a.totalfare) AS max_fare');
$query->from('`#__postacab` AS a');
$db->setQuery($query);
$results = $db->loadObject();
$min_fare = $results->min_fare;
$max_fare = $results->max_fare;

$max_budget = $this->getState('filter.max-budget');
$min_budget = $this->getState('filter.min-budget');
if (!empty($max_budget))
{
	$max_budget = $max_budget;
	$min_budget = $min_budget;
}else
{
	$max_budget = $max_fare;
	$min_budget = $min_fare;
}

//echo"<pre>";print_r($this->items);exit;

$db = JFactory::getDbo();
$sql="SELECT id, cab_type from #__cab_type";
$db->setQuery($sql);
$results1=$db->loadObjectlist();
//echo $results1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<style>
		#slider5a .slider-track-high, #slider5c .slider-track-high {background: black;}
		#slider5b .slider-track-low, #slider5c .slider-track-low {background:black;}
		#slider5c .slider-selection {background: yellow;}
		.slider-handle {background-color: #337ab7; background-image: linear-gradient(to bottom, #fbe601, #fbe601 100%); background-repeat: repeat-x; border: 0 solid transparent; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05); filter: none; height: 20px;  position: absolute; width: 20px;}
		.dropdown {position: relative; display: inline-block;}
		.dropdown-content {display: none; position: absolute; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);  padding: 12px 16px;  z-index: 1;}
		.dropdown:hover .dropdown-content {display: block;}
		.nav.navbar-nav input {background-color: #f7f7f7;  border: 1px solid #e6e6e6;  padding: 6px 11px;}
		.navbar-default .navbar-nav > li > a {color: #000;}
		.direction {background:url("img/logos/header-icon.jpg") no-repeat scroll 0 0; /*margin: 2px -11px;*/}
		#filter_button{margin:10px;}
		.row.side_bar {background-color: #fafafa; border-right: 1px solid #e3e3e3; margin:0}
		#date {background-color: #fbe601; padding: 4px 14px;}
		.btn.date.dropdown-toggle {border: 1px solid #dbdbdb;}
		.btn.date.dropdown-toggle {border-radius: 1px;}
		.filter_form {margin: 0;}
		.filter_form .form-group {margin: 0;}

		/*Price range*/
		.budget{color: #fff; display: inline-block; margin-bottom: 5px;}
		.budget .max-budget,.budget .min-budget{background: url("../images/line.png") no-repeat scroll bottom center / 95% 5px; border: medium none; color: #fff; font-size: 16px;   -webkit-appearance: none;  /*Removes default chrome and safari style*/  -moz-appearance: none; /* Removes Default Firefox style*/ box-shadow:none; height: 40px;}
		.budget img.img-responsive {float: left; padding: 5px 5px 5px 0;}
		.city option,.gender option,.landmark option{padding-left: 50px; color: #e84c3d; background: #fff; font-weight: normal;}
		.budget label {padding: 0; text-align: center;}
		input.min-budget:focus,input.max-budget:focus{border: none; box-shadow: none;}
		.search-pg-frm  .form-control::-webkit-input-placeholder,.search-pg-frm  .min-budget::-webkit-input-placeholder,.search-pg-frm  .max-budget::-webkit-input-placeholder{color: #fff; font-size: 16px;}
		.search-pg-frm  .form-control::-moz-placeholder,.search-pg-frm  .min-budget::-moz-placeholder,.search-pg-frm  .max-budget::-moz-placeholder{color: #fff; font-size: 16px;}
		.search-pg-frm  .form-control:-ms-input-placeholder,.search-pg-frm  .min-budget:-ms-input-placeholder,.search-pg-frm  .max-budget:-ms-input-placeholder{color: #fff; font-size: 16px;}
		.budget-bar {margin-top: 10px; font-size: 0.8em!important;}
		.budget-bar .ui-widget-header{background: #e84c3d;}
		.budget div {padding: 0;}
	</style>

<link href="<?php echo JURI::root();?>modules/mod_banner/js/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<link rel="Stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css" />
<script src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places" type="text/javascript" ></script>
<script src="<?php echo JURI::root();?>modules/mod_banner/js/jquery.placepicker.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>modules/mod_banner/js/jquery.timepicker.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::ROOT(); ?>js/rating.js"></script>


<!-- Book A Cab -->
<script>
    function userlogin1()
    {
		alert("Please Login to Join a Cab");
    }
</script>



<script>
	jQuery(document).ready(function(){
		<!-- Place picker -->
		jQuery(".placepicker").placepicker();
		jQuery(".find_btn").click(function(){
			jQuery(this).each(function(){
             var drname=jQuery(this).parent(".join_cab").find(".drname").val();
             var drmobile=jQuery(this).parent(".join_cab").find(".drmobile").val();
             var drcbtype=jQuery(this).parent(".join_cab").find(".drcbtype").val();
             var uname=jQuery(this).parent(".join_cab").find(".uname").val();
             var umobile=jQuery(this).parent(".join_cab").find(".umobile").val();
             jQuery.ajax
				({
				   	type: "POST",
				   	url: "<?php echo JURI::root();?>index.php?option=com_bookacab&task=postcabform.joinnow",
				   	data: {drname:drname,drmobile:drmobile,drcbtype:drcbtype,uname:uname,umobile:umobile},
				   	success: function(data)
				   	{
				   	  	alert(data);
				   	}
			 	});
		 });
		});
	});

	<!-- Listing Page Cab type Filtering -->
	jQuery(document).on("change",".list .listCompare",function(){
		jQuery(this).each(function(){
            var list=jQuery("input[name='ctyp[]']");
	        var len=list.length;
	        var arr1=[];
	        for(i=0;i<len;i++)
			{
			     if(list[i].checked==true)
				 {
				   var vals=list[i].value;
				   arr1.push(vals);
				 }
			}
			tot=arr1.toString();
			jQuery.ajax
            ({
                 type: "POST",
                 url: "<?php echo JURI::root();?>index.php?option=com_bookacab&task=postcabform.cartypes",
                 data:{list:tot},
                 success: function(data)
                 {
                   jQuery(".results_details").html(data);
                 }
             });
		});

	<!-- Listing Page Price Range Filtering -->
	jQuery(document).on("change",".pramnts .priceCompare",function(){
		jQuery(this).each(function(){
            var list1=jQuery("input[name='maxamt']");

	        var len=list1.length;
	        var arr1=[];
	        for(i=0;i<len;i++)
			{
			     if(list1[i].checked==true)
				 {
				   var vals=list1[i].value;
				   arr1.push(vals);
				 }
			}
			tot=arr1.toString();
			jQuery.ajax
            ({
                 type: "POST",
                 url: "<?php echo JURI::root();?>index.php?option=com_bookacab&task=postcabform.pricerange",
                 data:{list:tot},
                 success: function(data)
                 {
                 	jQuery(".results_details").html(data);
                 }
             });
		});
	});
});
</script>

</head>
<body>
<section id="header_search">
	<header class="navbar navbar-default" role="banner">
	  <div class="container menus">
	    <div class="navbar-header">
	      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a href="#" class="navbar-brand" id="search">Your Search</a>
	    </div>
	    <nav class="collapse navbar-collapse" role="navigation">
	      <div class="nav navbar-nav search_cabme" id="nav-list">
	      	  <form id="searchridelist" action="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcabs'); ?>" method="post" enctype="multipart/form-data">
			      <div class="loc-map cab_from"><label>From:</label><input name="filter[source]" class="placepicker" id="icon" type="text" /></div>
			      <div class="cab_refresh"><a href="#" id="dir-image"  class="direction"><img src="<?php echo JURI::base(); ?>/images/header-icon.jpg"></a></div>
			      <div class="cab_from"><label>To:</label><input name="filter[destination]" class="placepicker" id="icon1" type="text" /></div>
			      <div class="cabs_reset"><button class="btn hasTooltip js-stools-btn-clear" onclick="jQuery(this).closest('form').find('input').val('');" data-original-title="Clear" title="" type="button"> Reset </button></div>
			      <div class="cab_findnow"><input type="submit" id="find-btn" class="btn btn primary findnowval" value="FIND NOW"></div>
			      <!--<div class="cab_offerride"><a href="#"><button type="button" id="offer-btn" class="hidden btn btn primary offer_btn">OFFER A RIDE</button></a></div>-->
		      </form>
	      </div>
	    </nav>
	  </div>
	</header>
</section>

<section id="search_details" class="row">
	<div class="filter_details pull-left col-md-3">
		 <div id="page-wrapper" class="side_menu">
			<h2 id="filter_by">Filter By</h2>
			<div class="row side_bar">
				<div>
					<form class="form-horizontal filter_form" method="post" id="cabdatefilter" role="form" action="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcabs'); ?>">
						<div class="form-group" id="date"><p  class="calender_image">DATE OF JOURNEY<p></div>
						<div class="form-group " id="cal_img"><img src="<?php echo JURI::base(); ?>/images/calendar.jpg"></div>
						<div class="form-group date1">
							<div class="date_time">
								<div class="cabme_date">
									<input type="text" name="filter[cabme_date]" placeholder="DD/MM/YY" id="cabme_date" value="<?php echo $cabme_date; ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="date_time">
								<div class="cabme_time">
									<input type="text"  name="filter[cabme_time]" placeholder="Select Time Format" id="cabme_time" value="<?php echo $cabme_time; ?>">
								</div>
							</div>
						</div>
						<div class="form-group search_datetime"><input type="submit" id="find-btn" class="btn btn primary find_btn" value="FIND NOW"></div>
						<div class="cabme_border"></div>

						<div class="form-group p"><p id="price">PRICE</p></div>
						<div class="price_range">
				        	<div class="min_max">
				        		<input type="text"  name="filter[min-budget]" id="min-budget" value="">
				        		<input type="text"  name="filter[max-budget]" id="max-budget" value="">
      						</div>
      						<div id="slider-3"></div>
						</div>

						<div class="form-group">
							<p id="price">CAR TYPE</p>
							<ul class="list cab_cartype">
		 						<?php foreach($results1 as $res1){?>
									<!--<li value="<?php echo $res1->id; ?>"><?php echo $res1->cab_type; ?> </li>-->
									<li class="list" ><input class="listCompare" id="num_<?php echo $res1->id; ?>" value="<?php echo $res1->id; ?>" name="ctyp[]"  type="checkbox"><label for="num_<?php echo $res1->id; ?>"><?php echo $res1->cab_type; ?><label></li>
								<?php } ?>
							</ul>
						</div>
						<div class="form-group">
							<p id="price">EXPERIENCE</p>
							<ul class="list cab_experience">
								<li class="list"><input type="checkbox" name="prange">&nbsp;&nbsp;intermidiate</li>
								<li class="list"><input type="checkbox" name="prange">&nbsp;&nbsp;All Types</li>
							</ul>
						</div>
						<div class="form-group cab_refin">
							<button class="btn hasTooltip js-stools-btn-clear" onclick="jQuery(this).closest('form').find('input').val('');" data-original-title="Clear" title="" type="button">REFINE NOW</button>
						</div>
						<!-- /.container-fluid -->
					</form>
				</div>

			</div>
			<!-- /.container-fluid -->
		</div>
	</div>
	<?php
		$itemcount= count($this->items);
		$limitstart =JRequest::getvar('limitstart',0);
         $limit = 3;
		 $this->pagination	= new JPagination($itemcount, $limitstart, $limit);
	?>
	<form action="<?php echo JRoute::_('index.php?option=com_bookacab&view=postcabs'); ?>" method="post" name="adminForm" id="adminForm" class="col-md-9">
		<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__));  ?>
		<?php if($itemcount==0)
	  { ?>
        <div class="no_records">No records found</div>
	  <?php } else { ?>
		<div class="results_details pull-left col-md-12">

        <?php foreach ($this->items as $i => $item) :
        ?>

		<div class="row results_list">
		     <?php
		        $currentcab=$item->cab_type;
		     	$db = JFactory::getDbo();
    			$query1="select cab_type from #__cab_type where id=$currentcab";
    			$db->setQuery($query1);
    			$cabval = $db->loadResult();
              ?>
			<div class="col-sm-3 pull-left driver_profile">
				<div class="cus-pic">
					<?php
				       $uid=$item->modified_by;
				       $db=&JFactory::getDBO();
				       $query1="select profile_pic from #__users where id=$uid";
		    		   $db->setQuery($query1);
		    		   $picval = $db->loadResult();
		    		   if(!empty($picval))
		    		   {
		            ?>
		            <img src="<?php echo JURI::root().'components/com_users/profilepic/'.$picval; ?>" />
		            <?php } else{  ?>
                        <img src="<?php echo JURI::root().'images/no-profile-img.png' ?>" />
		           <?php } ?>
				</div>

				<div class="cus-name">
					<h6><b><a href="<?php echo JRoute::_('index.php?option=com_bookacab&view=postcab&id='.(int) $item->id); ?>">
								<?php echo $this->escape($item->name); ?></a></b></h6>
				    <p class="no-rides">No of rides : <span class="no_r">5<span></p>

				    <!--<div class="cab_rating"><label>Rating :</label><img src="<?php echo JURI::base(); ?>/images/star.png"></div>-->
					<div class="str_rate">
           				<?php
							$PRD_ID= $item->id;
							$tv=0; $v=0; $rat=0;
							$db = &JFactory::getDBO();
							$query = "SELECT total_votes, total_value  FROM #__ratings WHERE id=$PRD_ID";
							$db->setQuery($query);
							$rates = $db->loadobject();
							if($rates)
							{
								$v=$rates->total_votes;
								$tv=$rates->total_value;
								$rat=@($tv/$v);
							}
							echo'<div class="product">
					            <div id="'.$PRD_ID.'"  class="ratings">';
					                for($k=1;$k<6;$k++){
										if($rat+0.5>$k)$class="star_".$k."  ratings_stars ratings_vote";
										else $class="star_".$k." ratings_stars ratings_blank";
										echo '<div class="'.$class.'"></div>';
										}
					                echo'<!--<div class="total_votes"><p class="voted"> Rating: <strong>'.@number_format($rat).'</strong>/5 ('.$v. '  vote(s) cast)
					            </div>-->
						        </div></div>';
							?>
           			</div>
				</div>
			</div>

			<div class="col-sm-7 cab_trip">
				<h3><span class="cab_date"><?php echo date("l j F",strtotime($item->date)); ?></span>-<span class="cab_timing"><?php echo $item->time; ?></span> </h3>

				<!--
				<div class="row routes">
					<div class="col-xs-2 "><p>Bangalore</p></div>
					<div class="col-xs-1 arrow_image"></div>
					<div class="col-xs-1 sec_route">Hubli</div>
					<div class="col-xs-1 arrow_image"></div>
					<div class="col-xs-1 third_route">Kohlapur</div>
			    </div>
			    -->
	            <p class="source_image"><?php echo $item->from; ?></p>
	            <p class="dest_image"><?php echo $item->to; ?></p>
	            <br>
	            <div class="row car-type">
	                <div class="pull-left col-sm-5"><p class="cab_name">Car Type : <span class="cab_comp"><?php echo $cabval; ?></span> </p></div>
	                <div class="col-sm-1"><p class=""><span class="or1"></span></p></div>
	                <div class="col-sm-6">
	                    <div class="row facilities">
	                        <div class="col-sm-4 cab_allowed"><p>Allowed :</p></div>
	                        <?php
	                         if($item->smoke=="1")
	                         {?>
                                <div class="col-sm-1 allowed_facility">
								 <img src="<?php echo JURI::base(); ?>/images/s_allow.png" />
							    </div>
	                         <?php }
	                         else
	                         {?>
	                         	<div class="col-sm-1 allowed_facility">
								 <img src="<?php echo JURI::base(); ?>/images/s_notallow.png" />
							   </div>

	                         <?php }
	                        ?>

	                        <?php
	                         if($item->pet=="1")
	                         {?>
								<div class="col-sm-1 allowed_facility2">
									<img src="<?php echo JURI::base(); ?>/images/p_allow.png" />
								</div>
	                         <?php }
	                         else
	                         {?>
	                         	<div class="col-sm-1 allowed_facility">
								 <img src="<?php echo JURI::base(); ?>/images/p_notallow.png" />
							   </div>

	                         <?php }
	                        ?>

	                        <?php
	                         if($item->music=="1")
	                         {?>
								<div class="col-sm-1 allowed_facility2">
									<img src="<?php echo JURI::base(); ?>/images/m_allow.png" />
								</div>
	                         <?php }
	                         else
	                         {?>
	                         	<div class="col-sm-1 allowed_facility">
								 <img src="<?php echo JURI::base(); ?>/images/m_notallow.png" />
							   </div>

	                         <?php }
	                        ?>
	                    </div>
	                </div>
	            </div>
	        </div>

	        <div class="col-sm-2 third-row">
	            <p class="verified">verified<span class="thumb_image"><img src="<?php echo JURI::base(); ?>/images/verified.jpg"></span></p>
	            <div class="cab_rate"><img src="<?php echo JURI::base(); ?>/images/rupee.png"> <h3 class="rupee"><?php if($item->totalfare) echo $item->totalfare;else echo "Not defined"; ?></h3></div>
	            <p class="s pre">Per Co-traveller</p>

	            <div class="join_cab">
	            	<?php
					$user =JFactory::getUser();
					$userId = $user->get( 'id' );
					$userName = $user->get( 'name' );
					$userMobile = $user->get( 'mobile' );

					if(!empty($userId))
					{

					?>
					<input id="find_cab" class="btn btn primary find_btn" type="button" value="JOIN NOW">
					<input type="hidden" class="drname" value="<?php echo $item->name;  ?>" />
					<input type="hidden" class="drmobile" value="<?php echo $item->mobile;  ?>" />

					<input type="hidden" class="drcbtype" value="<?php echo $item->cab_type;  ?>" />
					<input type="hidden" class="uname" value="<?php echo $userName;  ?>" />
					<input type="hidden" class="umobile" value="<?php echo $userMobile;  ?>" />

					<?php }

					else{ ?>
						<input class="btn btn primary find_btn_user" onclick="return userlogin1();" type="button" value="JOIN NOW">
					<?php } ?>

	            </div>
	            <div class="row cab_seatleft">
	               <?php
	               for($i=0;$i< $item->no_of_seats;$i++)
	               { ?>
	                <div class="col-sm-2 seats">
	                	<img src="<?php echo JURI::base(); ?>/images/seat.jpg">
	                </div>
	               <?php } ?>
	            </div>
	            <div class="row">
	                <div class="col-xs-0 no"><?php echo $item->no_of_seats; ?>&nbsp;<span class="s">Seats left</span></div>
	            </div>
	        </div>
    </div>
	<?php endforeach; ?>

	</div>

	<?php if ($canCreate) : ?>
		<!-- <a href="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcabform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_BOOKACAB_ADD_ITEM'); ?></a> -->
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
	<?php } ?>
</form>

<!-- Area for pagination -->
		<!--<div class="pagination pagination-toolbar">
		    <?php	echo $this->pagination->getPagesLinks();?>
		</div>-->
		<!-- Area for pagination Ends-->
<?php  if($canDelete) : ?>
</section>
</body>
<?php endif; ?>

<!--<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});
	function deleteItem() {
		if (!confirm("<?php echo JText::_('COM_BOOKACAB_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>-->
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function(){
		<!-- Listing Page Date, Time Validation -->
		/*jQuery("#cabdatefilter").validate({
	       	rules: {
	       		 'filter[cabme_date]': "required",
	             'filter[cabme_time]': "required"
	       	},
	       	messages: {
	            'filter[cabme_date]': "Select your date",
	            'filter[cabme_time]': "Select your time"
	       	},

	       	submitHandler: function(form) {
	            form.submit();
	        }

        });*/

       	<!-- Listing Page Search Module Validation -->
		jQuery("#searchridelist").validate({
	       	rules: {
	       		 'filter[source]': "required",
	       		 'filter[destination]': "required"
	            },
	       	messages: {
	            'filter[source]': "Select your Source",
	            'filter[destination]': "Select your Destination"
	       	},
	       	submitHandler: function(form) {
	            form.submit();
	            //return false;
	        }
        });


		<!-- From and To Places Auto Search module & Book a Cab -->
		jQuery("#advanced-placepicker").each(function() {
			var target = this;
			var jQuerycollapse = jQuery(this).parents('.form-group').next('.collapse');
			var jQuerymap = jQuerycollapse.find('.another-map-class');
			var placepicker = jQuery(this).placepicker({
				map: jQuerymap.get(0),
				placeChanged: function(place) {
					console.log("place changed: ", place.formatted_address, this.getLocation());
				}
			}).data('placepicker');
		});

		<!-- Time Picker Book a Cab & Post a Cab -->
		jQuery('#cabme_time').timepicker({
    		'showDuration': true,
    		//'timeFormat': 'g:ia'
		});

		<!-- Date Picker Book a Cab & Post a Cab -->
		var dateToday = new Date();
		jQuery('#cabme_date').datepicker({
		    minDate: dateToday,
		    dateFormat: 'd-M-yy'
			//showOn: 'button',
		    //buttonImageOnly: true,
		    //buttonImage: './images/slices/cal.png',
		});

		<!-- rating-->
		jQuery('.star').hover(
			function() {
				jQuery(this).prevAll().andSelf().addClass('over');
				jQuery(this).nextAll().removeClass('over');
			}
		);

		jQuery('.star').click(
			function() {
				jQuery(this).prevAll().andSelf().addClass('over');
				jQuery(this).nextAll().removeClass('over');
			}
		);

		//send ajax request to rate.php
		/*jQuery('.<?php echo $item->id ?> .star').bind('click', function() {
			var num 	=	jQuery(this).attr("id");
			//alert(num);

			var path = document.getElementById('site_path').value;
			var mid  = document.getElementById('mod_id_'+<?php echo $item->id ?>).value;
			//alert(mid);
			var queryString = path + 'index.php?option=com_pg_details&task=pgdetails.ratings&star='+num+'&pgid='+mid;
				jQuery.ajax({url: queryString,cache:0,data:num,success:function(result){
					document.getElementById('vresult'+<?php echo $item->id ?>).innerHTML=result;
				}
			});
		});*/
		<!-- rating-->

	});
</script>



<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery( "#slider-3" ).slider({
      range: true,
      min: <?php echo $min_fare; ?>,
      max: <?php echo $max_fare; ?>,
      values: [ <?php echo $min_budget; ?>, <?php echo $max_budget; ?> ],
	  start: function (event, ui) {
			event.stopPropagation();
		},
      slide: function( event, ui ) {
        jQuery( "#min-budget" ).val( ui.values[ 0 ]);
		jQuery( "#max-budget" ).val( ui.values[ 1 ]);
      },
	   change: function(event, ui) {
           jQuery(".filter_form").submit();
        }
    });

     jQuery( "#min-budget" ).val( jQuery( "#slider-3" ).slider( "values", 0 ));
	 jQuery( "#max-budget" ).val( jQuery( "#slider-3" ).slider( "values", 1 ));

     });
</script>



