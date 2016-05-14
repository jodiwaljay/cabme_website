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
		        		<ul class="btn-toolbar pull-right">
							<li class="btn-group">
								<a class="btn" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id);?>">
									<span class="icon-user"></span> <?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?>
								</a>
							</li>
						</ul>
		         		<?php echo $this->loadTemplate('core'); ?>
				 	</div>
		         	<div class="tab-pane" id="change-pass-link"><?php echo $this->loadTemplate('changepassword'); ?></div>
		         	<div class="tab-pane" id="ride-link">
<!---tabs------>
		         	<div class="ride-tab" id="nav-tabs">
                 		<p class="ride">Ride Details</p>
						<ul class="nav nav-tabs tabs" >
							<li class="active"><a data-toggle="tab" href="#home">Upcoming Rides</a></li>
							<li><a data-toggle="tab" href="#home2">Past Rides</a></li>
							<li><a data-toggle="tab" href="#home3">Preferences</a></li>
							<!-- <li><a data-toggle="tab" href="#menu2">Achived Rides</a></li> -->
					    </ul>


						<div class="tab-content">
							<div id="home" class="tab-pane fade in active">
						 <?php
						     $db = JFactory::getDbo();
						     	$user = JFactory::getUser();
						     	$today = date("Y-m-d");
								$compare_date = date("Y-m-d", strtotime("$today"));

						    	$query= "select * from #__postacab where date >= '$compare_date' and modified_by= '$user->id'";
						    	$db->setQuery($query);
						    	$results = $db->loadObjectlist();

	                            foreach($results as $k=>$postlist)
	                            {?>
								<div class="row rides_detail">
									<div class="col-sm-5">
										<h3><span class="cab_date"><?php echo date("l j F",strtotime($postlist->date)); ?></span>-<span class="cab_timing"><?php echo $postlist->time; ?></span></h3>
										<div class="row routes">
											<!--<div class="col-xs-2  source_city"><p>Bangalore</p></div>
											<div class="col-xs-1 arrow_image"></div>
											<div class="col-xs-1 sec_route">Hubli</div>
											<div class="col-xs-1 arrow_image"></div>
											<div class="col-xs-1 third_route">Kohlapur</div>-->
										</div>
										<p class="source_image"><?php echo $postlist->from; ?></p>
										<p class="dest_image"><?php echo $postlist->to; ?></p>
									</div>
									<div class="col-sm-4 car_type">
									<?php
										$currentcab=$postlist->cab_type;
										$db = JFactory::getDbo();
										$query1="select cab_type from #__cab_type where id=$currentcab";
										$db->setQuery($query1);
										$cabval = $db->loadResult();
									?>

									   <h4 class="allowed">Car Type : <span class="car-names"><?php echo $cabval; ?></span></h4>
									   <div class="amenities_allow">
							               <div class="amenities">
							                     <div class="Allowed"><h4>Allowed:</h4></div>
							                        <?php
							                         if($postlist->smoke=="1")
							                         {?>
						                                <div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/s_allow.png" />
													    </div>
							                         <?php }
							                         else
							                         {?>
							                         	<div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/s_notallow.png" />
													   </div>

							                         <?php }
							                        ?>

							                        <?php
							                         if($postlist->pet=="1")
							                         {?>
														<div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/p_allow.png" />
														</div>
							                         <?php }
							                         else
							                         {?>
							                         	<div class="allowed_img">
														 <img src="<?php echo JURI::base(); ?>/images/p_notallow.png" />
													   </div>

							                         <?php }
							                        ?>

							                        <?php
							                         if($postlist->music=="1")
							                         {?>
														<div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/m_allow.png" />
														</div>
							                         <?php }
							                         else
							                         {?>
							                         	<div class="allowed_img">
														 <img src="<?php echo JURI::base(); ?>/images/m_notallow.png" />
													   </div>

							                         <?php }
							                        ?>
							               </div>
									   </div>
							       </div>
							       <div class="col-sm-3 seat">
	           				            <div class="cab_rate1"><img src="<?php echo JURI::base(); ?>/images/rupee.png"> <h3 class="rupee1"><?php if($postlist->totalfare) echo $postlist->totalfare;else echo "Not defined"; ?></h3></div>
					                    <p class="s pre1">Pre co travller</p>
							            <div class="row cab_seatleft">
							               <?php
							               for($i=0;$i< $postlist->no_of_seats;$i++)
							               { ?>
							                <div class="col-sm-2 seats1">
							                	<img src="<?php echo JURI::base(); ?>/images/seat.jpg">
							                </div>
							               <?php } ?>
							            </div>
							            <div class="row">
							                <div class="col-xs-0 no1"><?php echo $postlist->no_of_seats; ?>&nbsp;<span class="s">Seats left</span></div>
							            </div>
						     		</div>
								</div>
	                          <?php }
						 ?>

							</div>
                            <div id="home2" class="tab-pane fade">
						 	<?php
						     $db = JFactory::getDbo();
						     	$user = JFactory::getUser();
						     	$today = date("Y-m-d");
								$compare_date = date("Y-m-d", strtotime("$today"));

						    	$query= "select * from #__postacab where date < '$compare_date' and modified_by= '$user->id'";
						    	$db->setQuery($query);
						    	$results = $db->loadObjectlist();
	                            foreach($results as $k=>$postlist)
	                            {?>
								<div class="row rides_detail">
									<div class="col-sm-5">
										<h3><span class="cab_date"><?php echo date("l j F",strtotime($postlist->date)); ?></span>-<span class="cab_timing"><?php echo $postlist->time; ?></span></h3>
										<div class="row routes">
											<!--<div class="col-xs-2  source_city"><p>Bangalore</p></div>
											<div class="col-xs-1 arrow_image"></div>
											<div class="col-xs-1 sec_route">Hubli</div>
											<div class="col-xs-1 arrow_image"></div>
											<div class="col-xs-1 third_route">Kohlapur</div>-->
										</div>
										<p class="source_image"><?php echo $postlist->from; ?></p>
										<p class="dest_image"><?php echo $postlist->to; ?></p>
									</div>
									<div class="col-sm-4 car_type">
									<?php
										$currentcab=$postlist->cab_type;
										$db = JFactory::getDbo();
										$query1="select cab_type from #__cab_type where id=$currentcab";
										$db->setQuery($query1);
										$cabval = $db->loadResult();
									?>

									   <h4 class="allowed">Car Type : <span class="car-names"><?php echo $cabval; ?></span></h4>
									   <div class="amenities_allow">
							               <div class="amenities">
							                     <div class="Allowed"><h4>Allowed:</h4></div>
							                        <?php
							                         if($postlist->smoke=="1")
							                         {?>
						                                <div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/s_allow.png" />
													    </div>
							                         <?php }
							                         else
							                         {?>
							                         	<div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/s_notallow.png" />
													   </div>

							                         <?php }
							                        ?>

							                        <?php
							                         if($postlist->pet=="1")
							                         {?>
														<div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/p_allow.png" />
														</div>
							                         <?php }
							                         else
							                         {?>
							                         	<div class="allowed_img">
														 <img src="<?php echo JURI::base(); ?>/images/p_notallow.png" />
													   </div>

							                         <?php }
							                        ?>

							                        <?php
							                         if($postlist->music=="1")
							                         {?>
														<div class="allowed_img">
															<img src="<?php echo JURI::base(); ?>/images/m_allow.png" />
														</div>
							                         <?php }
							                         else
							                         {?>
							                         	<div class="allowed_img">
														 <img src="<?php echo JURI::base(); ?>/images/m_notallow.png" />
													   </div>

							                         <?php }
							                        ?>
							               </div>
									   </div>
							       </div>
							       <div class="col-sm-3 seat">
	           				            <div class="cab_rate1"><img src="<?php echo JURI::base(); ?>/images/rupee.png"> <h3 class="rupee1"><?php if($postlist->totalfare) echo $postlist->totalfare;else echo "Not defined"; ?></h3></div>
					                    <p class="s pre1">Pre co travller</p>
							            <div class="row cab_seatleft">
							               <?php
							               for($i=0;$i< $postlist->no_of_seats;$i++)
							               { ?>
							                <div class="col-sm-2 seats1">
							                	<img src="<?php echo JURI::base(); ?>/images/seat.jpg">
							                </div>
							               <?php } ?>
							            </div>
							            <div class="row">
							                <div class="col-xs-0 no1"><?php echo $postlist->no_of_seats; ?>&nbsp;<span class="s">Seats left</span></div>
							            </div>
						     		</div>
								</div>
	                          <?php }
						 ?>
                            </div>
		                    <div id="home3" class="tab-pane fade"><h3>preferences</h3></div>
						</div>


    <!--<div id="menu2" class="tab-pane fade"><h3>Achived rides</h3></div>-->

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Tabs vertical end-->

<?php endif; ?>
<?php //echo $this->loadTemplate('core'); ?>

<?php /*echo $this->loadTemplate('params'); */?>

<?php echo $this->loadTemplate('custom'); ?>

</div>
