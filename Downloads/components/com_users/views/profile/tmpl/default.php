<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="profile<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
	<?php endif; ?>
	<?php if (JFactory::getUser()->id == $this->data->id) : ?>
	<!--Tabs vertical-->
	<div class="container profile-main-area">
		<ul class="btn-toolbar pull-right">
			<li class="btn-group">
				<a class="btn" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id);?>">
					<span class="icon-user"></span> <?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?></a>
			</li>
		</ul>
		<div class="row profile-menu">
			<div class="col-lg-3 col-sm-3 tabbable tabs-left left-tab-my-account" id="left-side-tab">
		         <ul class="nav nav-tabs">
			          <li class="my-account-link active"><a href="#my-account-link" data-toggle="tab">My account </a></li>
			          <li class="change-pass-link"><a href="#change-pass-link" data-toggle="tab">Change Password</a></li>
			          <li class="ride-link"><a href="#ride-link" data-toggle="tab">Ride Details</a></li>
					  <li class="logout"><a href="#" data-toggle="tab" onclick="document.logoutForm.submit();">Logout</a></li>
				</ul>
	        </div>

		    <div class="col-lg-9 col-sm-9 right-tabs-content">
	        	<div class="tab-content">
		        	<div class="tab-pane active" id="my-account-link">
		         		<?php echo $this->loadTemplate('core'); ?>
				 	</div>
		         	<div class="tab-pane" id="change-pass-link"><?php echo $this->loadTemplate('changepassword'); ?></div>
		         	<div class="tab-pane" id="ride-link">

<!---tabs------>

		         <div class="container ride-tab" id="nav-tabs">
                 	<p class="ride">Ride Details</p><br><br>
					<ul class="nav nav-tabs tabs" >
						<li class="active"><a data-toggle="tab" href="#home">Upcoming Rides</a></li>
						<li><a data-toggle="tab" href="#home">Past Rides</a></li>
						<!-- <li><a data-toggle="tab" href="#menu2">Achived Rides</a></li> -->
						<li><a data-toggle="tab" href="#menu3">Preferences</a></li>
				    </ul>

<div class="tab-content">
	<div id="home" class="tab-pane fade in active"><br>
		<section class="sec1">
	    	<div class="container">
	        	<div class="col-sm-6">
		    		<h3>Wednesday 25 December - 6:00 </h3>
                	<div class="row routes">
		                <div class="col-xs-2  source_city"><p>Bangalore</p></div>
		                <div class="col-xs-1 arrow_image"></div>
		                <div class="col-xs-1 sec_route">Hubli</div>
	                    <div class="col-xs-1 arrow_image"></div>
	                    <div class="col-xs-1 third_route">Kohlapur</div>
                    </div>
                    <p class="source_image">Jayanagar 4yh block, bangalore</p>
                    <p class="dest_image">Hubli old Bus Stand</p>
               </div>
	           <div class="col-sm-1 car_type ">
				   <p class="allowed">Car Type:<span class="car-names">HONDA AMAZONE </span></p>
		       </div>

                <div class="col-sm-3">
	                <div class="row amenities">
	                     <div class="col-sm-4   Allowed"><p>Allowed:</p></div>
	                     <div class="col-sm-1 allowed_facility"></div>
	                     <div class="col-sm-1 allowed_facility2"></div>
	                     <div class="col-sm-1 allowed_facility3"></div>
	                </div>
				</div>
   				<div class="col-sm-2 seat">
           			<h3 class="rupee">1020</h3>
                    <p class="s pre">Pre co travller</p><br>
                    <div class="row ">
                    	<div class="col-sm-2 seats"></div>
                        <div class="col-sm-2 seats seat2"></div>
                    </div>

                    <div class="row">
                    	<div class="col-xs-0 no">2&nbsp;<span class="s">Seats left</span></div>
                    </div>
	     		</div>
        </section>
	     <br>

    	<section class="sec1">
	    	<div class="container">
	    		<div class="col-sm-6">
		        	<h3>Wednesday 25 December - 6:00 </h3>
                    <div class="row routes">
                    	 <div class="col-xs-2  source_city"><p>Bangalore</p></div>
                         <div class="col-xs-1 arrow_image"></div>
                         <div class="col-xs-1 sec_route">Hubli</div>
                         <div class="col-xs-1 arrow_image"></div>
                         <div class="col-xs-1 third_route">Kohlapur</div>
                    </div>
                    <p class="source_image">Jayanagar 4yh block, bangalore</p>
                    <p class="dest_image">Hubli old Bus Stand</p>
                </div>

	            <div class="col-sm-1 car_type ">
                	<p class="allowed">Car Type:<span class="car-names">HONDA AMAZONE </span></p>
		        </div>

                <div class="col-sm-3">
                	<div class="row amenities">
                    	<div class="col-sm-4   Allowed"><p>Allowed:</p></div>
                        <div class="col-sm-1 allowed_facility"></div>
                        <div class="col-sm-1 allowed_facility2"></div>
                        <div class="col-sm-1 allowed_facility3"></div>
                    </div>
                </div>

	     		<div class="col-sm-2 seat">
           			<h3 class="rupee">1020</h3>
                    <p class="s pre">Pre co travller</p>
                    <br>

                    <div class="row ">
                    	<div class="col-sm-2 seats"></div>
                        <div class="col-sm-2 seats seat2"></div>
                    </div>

                    <div class="row">
	                    <div class="col-xs-0 no">2&nbsp;<span class="s">Seats left</span></div>
                    </div>
	     		</div>
        </section>
	</div>

	<div id="home" class="tab-pane fade in active">
    <br>
    	<section class="sec1">
        	<div class="container">
            	<div class="col-sm-6">
                	<h3>Wednesday 25 December - 6:00 </h3>
                    <div class="row routes">
                    	<div class="col-xs-2  source_city"><p>Bangalore</p></div>
                        <div class="col-xs-1 arrow_image"></div>
                        <div class="col-xs-1 sec_route">Hubli</div>
                        <div class="col-xs-1 arrow_image"></div>
                        <div class="col-xs-1 third_route">Kohlapur</div>
                    </div>
                    <p class="source_image">Jayanagar 4yh block, bangalore</p>
                    <p class="dest_image">Hubli old Bus Stand</p>
                </div>

                <div class="col-sm-1 car_type ">
                	<p class="allowed">Car Type:<span class="car-names">HONDA AMAZONE </span></p>
                </div>

                <div class="col-sm-3">
                	<div class="row amenities">
                    	<div class="col-sm-4   Allowed"><p>Allowed:</p></div>
                        <div class="col-sm-1 allowed_facility"></div>
                        <div class="col-sm-1 allowed_facility2"></div>
                        <div class="col-sm-1 allowed_facility3"></div>
                    </div>
                </div>

       			<div class="col-sm-2 seat">
           			<h3 class="rupee">1020</h3>
                    <p class="s pre">Pre co travller</p>
                              <br>
                    <div class="row ">
                    	<div class="col-sm-2 seats"></div>
                        <div class="col-sm-2 seats seat2"></div>
                    </div>

                    <div class="row">
                    	<div class="col-xs-0 no">2&nbsp;<span class="s">Seats left</span></div>
                    </div>
       		</div>
        </section>
        <br>

    	<section class="sec1">
        	<div class="container">
        		<div class="col-sm-6">
        			<h3>Wednesday 25 December - 6:00 </h3>
        			<div class="row routes">
        				<div class="col-xs-2  source_city"><p>Bangalore</p></div>
                        <div class="col-xs-1 arrow_image"></div>
                        <div class="col-xs-1 sec_route">Hubli</div>
                        <div class="col-xs-1 arrow_image"></div>
                        <div class="col-xs-1 third_route">Kohlapur</div>
                    </div>
                    <p class="source_image">Jayanagar 4yh block, bangalore</p>
                    <p class="dest_image">Hubli old Bus Stand</p>
                </div>

                <div class="col-sm-1 car_type ">
                	<p class="allowed">Car Type:<span class="car-names">HONDA AMAZONE </span></p>
                </div>

                <div class="col-sm-3">
                	<div class="row amenities">
	                    <div class="col-sm-4   Allowed"><p>Allowed:</p></div>
                        <div class="col-sm-1 allowed_facility"></div>
                        <div class="col-sm-1 allowed_facility2"></div>
                        <div class="col-sm-1 allowed_facility3"></div>
                    </div>
                </div>

       			<div class="col-sm-2 seat">
           			<h3 class="rupee">1020</h3>
                    <p class="s pre">Pre co travller</p>
                    <br>
                    <div class="row ">
                    	<div class="col-sm-2 seats"></div>
                    	<div class="col-sm-2 seats seat2"></div>
                    </div>

                    <div class="row">
                    	<div class="col-xs-0 no">2&nbsp;<span class="s">Seats left</span></div>
                    </div>
       			</div>
        </section>
	</div>


    <div id="menu2" class="tab-pane fade"><h3>Achived rides</h3></div>
	<div id="menu3" class="tab-pane fade"><h3>preferences</h3>
    	<section class="sec1">
        	<p>Lorem ipsum dolor sit </p>
	    </section>
	</div>


<!---tabs ends------>
</div>
</div>
<br>
       <center><button id="offer-btn" class="btn btn primary offer_btn" type="button">OFFER A RIDE</button></center>
		</div>
	</div>
</div>
<!--Tabs vertical end-->

<?php endif; ?>
<?php //echo $this->loadTemplate('core'); ?>

<?php /*echo $this->loadTemplate('params'); */?>

<?php echo $this->loadTemplate('custom'); ?>

</div>
