<?php //JHTML::_('behavior.modal');
defined('_JEXEC') or die;
JHTML::_('behavior.modal');

//require_once dirname(_FILE_). 'helper.php';
$user = JFactory::getUser();
$userid=$user->id;

session_start();

/***** get session values ******/

$storedate=$_SESSION['date'];
$storetime=$_SESSION['time'];
$storefrom=$_SESSION['from'];
$storeto=$_SESSION['to'];
$storecabtype=$_SESSION['cab_type'];
/***** get session values ******/

$slide=$_REQUEST['slide'];

$db = JFactory::getDbo();
$sql="SELECT name, email, mobile from  #__users where id=$userid";
$db->setQuery($sql);
$results=$db->loadObject();
//print_r($sql);
//exit;
$name =$results->name;
$mobile=$results->mobile;
$email=$results->email;

$sql="SELECT id, cab_type from #__cab_type";
$db->setQuery($sql);
$results1=$db->loadObjectlist();
?>


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="Stylesheet" href="<?php echo JURI::root();?>modules/mod_banner/css/slideshowforms.css" type="text/css" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="Stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css" />
	<link href="<?php echo JURI::root();?>modules/mod_banner/js/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places" type="text/javascript" ></script>
	<script src="<?php echo JURI::root();?>modules/mod_banner/js/jquery.placepicker.js" type="text/javascript"></script>
	<script src="<?php echo JURI::root();?>modules/mod_banner/js/jquery.timepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo JURI::root();?>modules/mod_banner/js/script.js" type="text/javascript"></script>
	<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

	<script>

	</script>
	<style>
		.carousel-inner > .item > img,
		.carousel-inner > .item > a > img {width: 100%;}
		.carousel-caption {float: left; margin-top: 20px ; left: 0; right: 0; top: 15%;}
		.yellow-text{color:#FBE601;}
		.right-text {color: #fff; float: right; text-align: center; margin-top: 100px;}
		.name-icon {background-image: url("http://localhost/projects/cabme/images/banner/Login-line.jpg"); background-repeat: no-repeat; padding-top: 20px;}
		.name-icon:first-child {background-image: url("http://localhost/projects/banner/images/Login-line.jpg");}
		.right-text h2 {color:#FBE601; font-weight: bold;}
		.img-icon {padding-right: 20px;  padding-left: 15px;}
		#user-name {background: url("images/banner/register-icon1.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#mobile {background: url("images/banner/register-icon2.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#email {background: url("images/banner/register-icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#password {background: url("images/banner/register-icon4.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		.input-text,.form-control.input-text:focus{border: none; padding: 0 0 10px 30px; width: 100%; box-shadow: none;}
		#cartype {background: url("images/banner/icon4.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#cartypeb {background: url("images/banner/icon4.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#from {background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line-half.png") no-repeat scroll center bottom;}
		#to {background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line-half.png") no-repeat scroll center bottom;}
		#date {background: url("images/banner/icon1.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line-half.png") no-repeat scroll center bottom;}
		#date1 {background: url("images/banner/icon1.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line-half.png") no-repeat scroll center bottom;}
		#time {background: url("images/banner/icon2.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line-half.png") no-repeat scroll center bottom;}
		#time1 {background: url("images/banner/icon2.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line-half.png") no-repeat scroll center bottom;}
		#pickup {background: rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		// #jform_pickuppoint {background: url("images/banner/icon.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		.jform_pickuppoint {background: url("images/banner/icon.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom; !important}

		.jform_pickuppoint {background: url("images/banner/icon.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom !important;}

		#postfrom{background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#postto{background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#bookfrom{background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		#bookto{background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}

		#rateperkm{background: url("images/banner/icon3.png") no-repeat scroll 0 0px, rgba(0, 0, 0, 0) url("images/banner/Login-line.png") no-repeat scroll center bottom;}
		.button-submit {background-color: #fbe601; border: medium none; color: #000; display: block; font-weight: bold; height: 50px; margin: 0 auto; width: 80%;}
		.date-time {width: 50%; float: left;}
		.background1 {/*background:rgba(54, 77, 93, 0.5);*/}
		.background2 {background-color:rgba(53, 35, 21, 0.4);}
		.background3 {background-color: rgba(1, 1, 1, 0.4);}
		.social-media ul li {display: inline-block; margin: 0 8px 0 5px;}
		.yellow-text-read{color:#FBE601; text-decoration: underline;}
		.form-group {margin-bottom: 20px;}
		.button-submit.book-cab-submit {width: 100%;}
		.pickup_group {float: left; width: 100%;}
		.Addmore_pickups #addpickup {background: yellow none repeat scroll 0 0; border: medium none; color: #000; font-weight: bold;  float: right; font-size: 11px; cursor: pointer; margin: 0 3px 3px;}
		#form-postcab {height: 470px; overflow-x: hidden; overflow-y: scroll;}
		.ibtnDel {background: yellow none repeat scroll 0 0; border: medium none; color: #000; float: right; font-size: 11px; font-weight: bold; margin: 0 3px 3px;}
		.modal-backdrop{z-index:-1 !important;}
	</style>



<div class="container-fluid">

   <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
    <!-- Indicators -->
    <!--
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
	-->
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item">
        <img src="images/banner/home-banner.jpg" alt="Chania" width="460" height="345">
         <div class="container  carousel-caption">
         <div class="col-md-5 background1">

         	<div class="search_ride">
  				<form id="searchridehome" action="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcabs'); ?>" method="post" enctype="multipart/form-data">
					<div class="search_src"><input id="#search_src" class="placepicker" type="text" name="filter[source]" placeholder="From :"/></div>
					<div class="search_ref"><img src="images/refrs.png" alt="search" /></div>
					<div class="search_dest"><input id="#search_dest" class="placepicker" type="text" name="filter[destination]" placeholder="To :" /></div>
					<div class="search_find"><input id="homesearchsubmit" type="submit" value="SEARCH NOW"></div>
				</form>
			</div>

          <!--
          <h3>REGISTER <span class="yellow-text">NOW..!!</span></h3>
            <form>
              <div class="form-group">
                <input type="text" class="form-control input-text" id="user-name" name="user-name" value="" placeholder="Name">
              </div>
              <div class="form-group">
                <input type="text" class="form-control input-text" id="mobile" name="mobile" value="" placeholder="Mobile No">
              </div>
              <div class="form-group">
                <input type="text" class="form-control input-text" id="email" name="email" value="" placeholder="Email ID">
              </div>
              <div class="form-group">
                <input type="password" class="form-control input-text" id="password" name="password" value="" placeholder="Create Password">
              </div>
              <div class="form-group">
                <button type="submit" class="button-submit">REGISTER NOW</button>
              </div>
              <div class="form-group">
                <img src="images/banner/or.png" alt="" />
              </div>
              <div class="form-group">
                <p>sign up with social media</p>
              </div>
              <div class="form-group social-media">
                <ul>
                  <li>
                    <a href="#"><img src="images/banner/fb.png" alt="Facebook" /></a>
                  </li>
                  <li>
                    <a href="#"><img src="images/banner/google.png" alt="Google" /></a>
                  </li>
                  <li>
                    <a href="#"><img src="images/banner/twit.png" alt="Twitter" /></a>
                  </li>
                  <li>
                    <a href="#"><img src="images/banner/linkd.png" alt="Linkdin" /></a>
                  </li>
                </ul>
              </div>
            </form>
            -->
         </div>
         <div class="col-md-7">
         	<div class="right-text">
          		<h3>Get cars from all Segments at</h3>
          		<h2>BEST DISCOUNTS,<br>BEST PRICES</h2>
          		<p>The lorem ipsum text is typically a scrambled section of De finibus </p>
        	</div>
         </div>
      </div>
    </div>
    <div class="item">
        <img src="images/banner/banner2.jpg" alt="Chania" width="460" height="345">
          <div class="container  carousel-caption">
            <div class="col-md-5 background2">
              <h3>POST A <span class="yellow-text">CAB..!!</span></h3>
              <form id="form-postcab" action="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcabform.save'); ?>" method="post">
	              <div class="form-group">
	                 <select class="form-control input-text" id="cartype" name="jform[cab_type]" >
	                 	<option value="">Choose Cab Type </option>
	 						<?php foreach($results1 as $res1){?>
								<option value="<?php echo $res1->id; ?>" <?php if(!empty($storecabtype)){ echo ($storecabtype==$res1->id)?'selected="selected"':''; } ?>><?php echo $res1->cab_type; ?> </option>
							<?php } ?>
	                 </select>
	              </div>
	              <div class="form-group">
	                <input type="text" class="placepicker form-control input-text" id="postfrom" name="jform[from]" value="<?php if(!empty($storefrom)){ echo $storefrom; } ?>" placeholder="From" >
	              </div>
	              <div class="form-group">
	                <input type="text" class="placepicker form-control input-text" id="postto" name="jform[to]" value="<?php if(!empty($storeto)){ echo $storeto; } ?>" placeholder="To" >
	              </div>

	              <div class="form-group date-time">
	                <input type="text" value="<?php if(!empty($storedate)){ echo $storedate; } ?>" class="form-control input-text" id="date1" name="jform[date]" placeholder="Date" >
	              </div>
	              <div class="form-group date-time">
	                <input type="text" value="<?php if(!empty($storetime)){ echo $storetime; } ?>" class="form-control input-text" id="time1" name="jform[time]" placeholder="Time" >
	              </div>

				  <!--<div class="pickup_group">
					  <div  class="Addmore_pickups"><div id="addpickup">Click to Add More Pickup Points</div></div>
					  <div class="form-group"><input type="text" class="placepicker form-control input-text jform_pickuppoint" id="jform_pickuppoint" name="pickuppoints[]" placeholder="Pickup Point"  ></div>
				  </div>
	  			  <div class="addmorepickups"></div>-->

	              <div class="form-group">
		              <input type="text" class="form-control input-text" id="rateperkm" name="jform[rate_perkm]" value="" placeholder="Rate/Km" >
	              </div>

	              <div class="form-group">
	                <select class="form-control input-text jform_pickuppoint" id="traveller" name="jform[no_of_seats]" >
	                  <option value="">No Of Seats</option>
	                  <option value="1">1</option>
	                  <option value="2">2</option>
	                  <option value="3">3</option>
	                  <option value="4">4</option>
	                </select>
	              </div>
	              <!--
	              <div class="form-group">
	                <input type="file" class="form-control input-text" id="image_file" name="image_file" value="" onclick="return userlogin2();" >
	              </div>
	              -->
	              <div class="form-group smoke_allow">
	              	<div class="allow_label"><label>Smoking</label></div>
	              	<div class="allow_fields">
		                <label><input type="radio" class="form-control" id="smoke" name="smoke" value="0" />NO</label>
		                <label><input type="radio" class="form-control" id="nosmoke" name="smoke" value="1" >YES</label>
	                </div>
	              </div>
	              <div class="form-group pets_allow">
	                <div class="allow_label"><label>Pets</label></div>
	                <div class="allow_fields">
		                <label><input type="radio" class="form-control" id="pets" name="pet" value="0" >NO</label>
		                <label><input type="radio" class="form-control" id="pets" name="pet" value="1" >YES</label>
	                </div>
	              </div>
	              <div class="form-group music_allow">
	              	<div class="allow_label"><label>Music</label></div>
	              	<div class="allow_fields">
		                <label><input type="radio" class="form-control" id="music" name="music" value="0" >NO</label>
		                <label><input type="radio" class="form-control" id="music" name="music" value="1" >YES</label>
	                </div>
	              </div>

	              <div class="form-group">
	                <input id="postcabsubmit" type="submit" class="button-submit book-cab-submit" value="Post A Cab">
					<input type="hidden" name="jform[name]"  value="<?php echo $name; ?>">
					<input type="hidden" name="jform[email]"  value="<?php echo $email; ?>">
					<input type="hidden" name="jform[mobile]"  value="<?php echo $mobile; ?>">
					<input type="hidden" id="distance" name="distance"  value="">
					<input type="hidden" name="option" value="com_bookacab"/>
					<input type="hidden" name="task" value="postcabform.save"/>
					<?php echo JHtml::_('form.token'); ?>
	              </div>
              </form>
         </div>

         <div class="col-md-7">
	         <div class="right-text">
	            <h3>Get cars from all Segments at</h3>
	            <h2>HOW TO ATTACH YOUR CAR WITH <br><span class="text-bold">CABME IN INDIA</span></h2>
	            <p>The lorem ipsum text is typically a scrambled section of De finibus </p>
	                <!--<button type="submit"><img src="images/banner/register-button.jpg" alt=""/></button>-->
	         </div>
         </div>
      </div>
    </div>


      <div class="item">
        <img src="images/banner/banner3.jpg" alt="Chania" width="460" height="345">
          <div class="container  carousel-caption">
            <div class="col-md-5 background3">
              <h3>BOOK A <span class="yellow-text">CAB..!!</span></h3>
            	<form id="formbookcab" method="post">
              		<div class="form-group date-time">
                		<input type="text" class="form-control input-text" id="date" name="jform[date]" value="" placeholder="Date of Travel" >
              		</div>
              		<div class="form-group date-time">
                		<input type="text" class="form-control input-text" id="time" name="jform[time]" value="" placeholder="Time" >
              		</div>
              		<div class="form-group source_cab">
                		<input type="text" class="placepicker form-control input-text" id="bookfrom" name="jform[from]" value="" placeholder="From" >
              		</div>
              		<div class="form-group dest_cab">
           	 			<input type="text" class="placepicker form-control input-text" id="bookto" name="jform[to]" value="" placeholder="To" >
              		</div>

              		<div class="form-group">
                 		<select class="form-control input-text" id="cartypeb" name="jform[cab_type]" >
     						<option value="">Choose Cab Type</option>
     						<?php foreach($results1 as $res1){?>
								<option value="<?php echo $res1->id; ?>"><?php echo $res1->cab_type; ?> </option>
							<?php } ?>
                		</select>
              		</div>
              		<div class="form-group">
                		<!--<input type="submit" class="button-submit book-cab-submit" onclick="return userlogin();" value="Book Now">-->
                		<div class="bookCab">
                			<a class="button-submit book-cab-submit">Book Now</a>
                		</div>
						<input id="bname" type="hidden" name="jform[name]"  value="<?php echo $name; ?>">
						<input id="bemail" type="hidden" name="jform[email]"  value="<?php echo $email; ?>">
						<input id="bmobile" type="hidden" name="jform[mobile]"  value="<?php echo $mobile; ?>">

						<?php echo JHtml::_('form.token'); ?>
              		</div>
				</form>
		  </div>
		  <div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog">
					        <div class="modal-content">
					            <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">
					                    <span aria-hidden="true">&times;</span>
					                    <span class="sr-only">Close</span></button>
					                <div class="modal-header pop-up share-cab">
										<center><h4 class="modal-title modal-title-color">Do You Want to Share a Cab</h4></center>
									</div>
					            </div>
					             <div class="modal-body">
					               <div class="pop-up-area">
									<form id="form-report" action="<?php echo JRoute::_('index.php?option=com_bookacab&task=bookcabform.save'); ?>" method="post" name="postForm" class="form-validate form-horizontal">
										<div class="radio" id="choice">
											<p><input id="choice1"  type="radio" name="optradio" value="Yes" />Yes</p>
											<p><input id="choice2"  type="radio"  name="optradio" value="No" />No</p>
										</div>
										<input type="hidden" name="jform[date]" value="">
										<input type="hidden" name="jform[time]" value="">
										<input type="hidden" name="jform[from]" value="">
										<input type="hidden" name="jform[to]" value="">
										<input type="hidden" name="jform[cab_type]" value="">

										<input type="hidden" name="jform[name]"  value="<?php echo $name; ?>">
										<input type="hidden" name="jform[email]"  value="<?php echo $email; ?>">
										<input type="hidden" name="jform[mobile]"  value="<?php echo $mobile; ?>">
										<?php echo JHtml::_('form.token'); ?>
									</form>
								  </div>
					             </div>
					        </div>
					    </div>
					</div>

         <div class="col-md-7">
          <div class="right-text">
            <h3>Get cars from all Segments at</h3>
            <h2>HOW TO ATTACH YOUR CAR WITH <br><span class="text-bold">CABME IN INDIA</span></h2>
            <p>The lorem ipsum text is typically a scrambled section of De finibus </p>
                <!--<button type="submit"><img class="register-button" src="images/banner/register-button.jpg" alt=""/><img class="offeride-button" src="images/banner/offeraride.png" alt=""/></button>-->
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>



<script type="text/javascript">

	jQuery(document).ready(function(){

		jQuery("#choice input[name='optradio']").click(function(){
			var pick=jQuery(this).val();
			if(pick=="Yes")
			{
            	//window.location="index.php?option=com_sppagebuilder&view=page&id=1&slide=2";
            	var datepass=jQuery("#form-report input[name='jform[date]']").val();
            	var timepass=jQuery("#form-report input[name='jform[time]']").val();
            	var frompass=jQuery("#form-report input[name='jform[from]']").val();
            	var topass=jQuery("#form-report input[name='jform[to]']").val();
            	var ctypepass=jQuery("#form-report input[name='jform[cab_type]']").val();

            	var namepass=jQuery("#form-report input[name='jform[name]']").val();
            	var emailpass=jQuery("#form-report input[name='jform[email]']").val();
            	var mobilepass=jQuery("#form-report input[name='jform[mobile]']").val();

            	jQuery.ajax
				 ({
				   type: "POST",
				   url: "<?php echo JURI::root();?>index.php?option=com_bookacab&task=postcabform.getpostform",
				   data: {datepass:datepass,timepass:timepass,frompass:frompass,topass:topass,ctypepass:ctypepass,namepass:namepass,emailpass:emailpass,mobilepass:mobilepass},
				   success: function(data)
				   {
				   	if(data=='1')
				   	{
				      alert("Thankyou for booking a Cab.");
				   	  window.location="index.php?option=com_sppagebuilder&view=page&id=1";
				   	}
				   }
				  });
			}
			else
			{
               jQuery('form#form-report').submit();
			}
		});

		 <?php
		   if($slide)

		   {?>
		    jQuery("#myCarousel .carousel-inner .item:first-child").removeClass('active');

		    //var tab_cls = '<?php echo $slide; ?>';
		    jQuery('#myCarousel .carousel-inner div:eq(1)').addClass('active');
		    //jQuery('#re'+tab_cls).addClass('active');
		<?php } ?>

		<!-- Storing Form Values From Book a Cab Form -->
		jQuery("#date").change(function(){
			var date=jQuery(this).val();
			jQuery('#form-report input[name="jform[date]"]').val(date);
		});

		/*jQuery("#time").change(function(){
			var timeparam=jQuery("#formbookcab #time").val();
			alert(timeparam);
			jQuery('#form-report input[name="jform[time]"]').val(timeparam);
		});*/
		google.maps.event.addDomListener(window, 'load', function () {
		    var places1 = new google.maps.places.Autocomplete(document.getElementById('bookfrom'));
		    google.maps.event.addListener(places1, 'place_changed', function () {
			    var place1 = places1.getPlace();
			    var bookfrom = place1.formatted_address;
			    jQuery('#form-report input[name="jform[from]"]').val(bookfrom);
			});
			var places2 = new google.maps.places.Autocomplete(document.getElementById('bookto'));
		    google.maps.event.addListener(places2, 'place_changed', function () {
			    var place2 = places2.getPlace();
			    var bookto= place2.formatted_address;
			    jQuery('#form-report input[name="jform[to]"]').val(bookto);
			});
	    });

		jQuery("#cartypeb").change(function(){
			var ctype=jQuery(this).val();
			jQuery('#form-report input[name="jform[cab_type]"]').val(ctype);
		});

		<!-- Home Page Search Module Validation -->
		jQuery("#searchridehome").validate({
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
	        }
        });

		<!-- Post a Cab Form Validation -->
		jQuery("#form-postcab").validate({
	       	rules: {
	       		 'jform[cab_type]': "required",
	       		 'jform[from]':"required",
	       		 'jform[to]': "required",
 	       		 'jform[date]': "required",
	       		 'jform[time]': "required",

	       		 'jform[rate_perkm]': "required",
	       		 'jform[no_of_seats]': "required"
            },

	       	messages: {
	       		 'jform[cab_type]': "Choose Cab Type",
	       		 'jform[from]': "Select Your Source",
	       		 'jform[to]': "Select Your Destination",
	       		 'jform[date]': "Select Date",
	       		 'jform[time]': "Select Time",
	       		 'jform[rate_perkm]': "Enter Rate/kms",
	       		 'jform[no_of_seats]': "choose No.of Seats"

	       	},

	       	submitHandler: function(form) {
	            form.submit();
	            //return false;
	        }
        });

		<!-- Book a Cab Form Validation -->
		jQuery("#formbookcab").validate({
	       	rules: {
	       		 'jform[date]': "required",
	       		 'jform[time]': "required",
	       		 'jform[from]': "required",
	       		 'jform[to]': "required",
 	       		 'jform[cab_type]': "required"
	            },
	       	messages: {
	       		 'jform[date]': "Select Date",
	       		 'jform[time]': "Select Time",
	       		 'jform[from]': "Select Your Source",
	       		 'jform[to]': "Select Your Destination",
 	       		 'jform[cab_type]': "Choose Cab Type"
	       	},
	       	submitHandler: function(form) {
	            form.submit();
	            return false;
	        }
        });


		jQuery(".bookCab a").click(function(event){

            var userid="<?php echo $userid; ?>";
	    	if(userid=='0')
	    	{
	    		event.preventDefault();
	    		showLoginForm();
	    	}
	    	else
	    	{
	    		if(jQuery("#formbookcab").valid())
	    		{
	    		  var timeparam=jQuery("#formbookcab #time").val();
			      jQuery('#form-report input[name="jform[time]"]').val(timeparam);
                  jQuery('#myModal').modal('show');

	    		}
	    		else
	    		{

	    		}

	    	}
		});

		<!-- Post a Cab Login Form Pop-up -->
		jQuery("#postcabsubmit").click(function(event){
           var userid="<?php echo $userid; ?>";
	    	if(userid=='0')
	    	{
	    		showLoginForm();
	    		return false;
	    	}
	    	else
	    	{
               jQuery("#form-postcab").valid();
	    	}
        });

		<!-- Home page Search Login Form Pop-up -->
		jQuery("#homesearchsubmit").click(function(event){
           var userid="<?php echo $userid; ?>";
	    	if(userid=='0')
	    	{
	    		showLoginForm();
	    		return false;
	    	}
	    	else
	    	{
               jQuery("#searchridehome").valid();
	    	}
        });


		<!-- From and To Places Auto Search module & Book a Cab -->
		jQuery(".placepicker").placepicker();
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
		jQuery('#time,#time1').timepicker({
    		'showDuration': true,
    		//'timeFormat': 'g:ia'
		});


		<!-- Date Picker Book a Cab & Post a Cab -->
		var dateToday = new Date();
		jQuery("#date,#date1").datepicker({
		    minDate: dateToday,
		    dateFormat: 'd-M-yy'
			//showOn: 'button',
		    //buttonImageOnly: true,
		    //buttonImage: './images/slices/cal.png',
		});

	});

	var counter = 1;
	jQuery(document).on("click","#addpickup",function(){

	    var newPickup = jQuery("<div class='pickup_group'>");
		var rows = "";
		rows += '<div class="removebtn Addmore_pickups"><button type="button" class="ibtnDel"  value="Delete">Delete</button></div>';
		rows += '<div class="form-group"><input type="text" class="form-control input-text jform_pickuppoint placepicker" id="jform_pickuppoint' + counter + '" name="pickuppoints[]" placeholder="Enter City Between Source and Destination"></div>';
		newPickup.append(rows);
		if (counter <=3)
		{
		 jQuery(".addmorepickups").append(newPickup);
		 counter++;
		}
		jQuery('.placepicker').placepicker();

	});

	jQuery(document).on("click",".ibtnDel",function(){
		jQuery(this).each(function(){
		    jQuery(this).parents(".pickup_group").remove();
			counter -= 1;
	  	});
	});
</script>





