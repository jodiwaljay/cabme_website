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

/**
 * Postcab controller class.
 *
 * @since  1.6
 */
session_start();
class BookacabControllerPostcabForm extends JControllerForm
{
	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	public function edit()
	{
		$app = JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_bookacab.edit.postcab.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_bookacab.edit.postcab.id', $editId);

		// Get the model.
		$model = $this->getModel('PostcabForm', 'BookacabModel');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=postcabform&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return void
	 *
	 * @throws Exception
	 * @since  1.6
	 */
	public function save()
	{
		$islogin = JRequest::getBool("islogin");
		// Check for request forgeries.
		if(!$islogin)
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('PostcabForm', 'BookacabModel');

		$user = JFactory::getUser();
		if(empty($user->id) || $user->id <= 0){
			$this->setRedirect(JURI::root(),"Please login");
			return false;
		}

		// Validate the posted data.
		$form = $model->getForm();
		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');
		//echo "<pre>";print_r($data);exit;

		$data["name"] = $user->name;
		$data["email"] = $user->email;
		$data["mobile"] = $user->mobile;

		if (!$form)
		{
			throw new Exception($model->getError(), 500);
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$input = $app->input;
			$jform = $input->get('jform', array(), 'ARRAY');

			// Save the data in the session.
			$app->setUserState('com_bookacab.edit.postcab.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.postcab.id');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=postcabform&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.

		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_bookacab.edit.postcab.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.postcab.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=postcabform&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_bookacab.edit.postcab.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_BOOKACAB_ITEM_SAVED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_bookacab&view=postcabs' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_bookacab.edit.postcab.data', null);


	}


	/**
	 * Method to abort current operation
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function cancel()
	{
		$app = JFactory::getApplication();

		// Get the current edit id.
		$editId = (int) $app->getUserState('com_bookacab.edit.postcab.id');

		// Get the model.
		$model = $this->getModel('PostcabForm', 'BookacabModel');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_bookacab&view=postcabs' : $item->link);
		$this->setRedirect(JRoute::_($url, false));
	}

	/**
	 * Method to remove data
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function remove()
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('PostcabForm', 'BookacabModel');

		// Get the user data.
		$data       = array();
		$data['id'] = $app->input->getInt('id');

		// Check for errors.
		if (empty($data['id']))
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_bookacab.edit.postcab.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.postcab.id');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=postcab&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->delete($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_bookacab.edit.postcab.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.postcab.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=postcab&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_bookacab.edit.postcab.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_BOOKACAB_ITEM_DELETED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_bookacab&view=postcabs' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_bookacab.edit.postcab.data', null);
	}


    public function cartypes()
    {
       $list=$_POST['list'];
       $model         = $this->getModel('postcabform');
       $combinelist   = $model->getlist($list);
       $count=count($combinelist);

       if($count<=0)
       {?>
       	  <div class="no_records">No records found</div>
       <?php }
       else
       {
       	foreach($combinelist as $i => $item)
       	{ ?>
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
								<?php echo $item->name; ?></a></b></h6>
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
							<a href="<?php echo JRoute::_('index.php?option=com_bookacab&view=bookcab&layout=popup&id='.$item->id.'&tmpl=component'); ?>" rel="{size: {x: 450, y: 400}, closable: true}" class="modal" id="find_cab">Join Now</a>
							<!--<input id="find_cab" class="btn btn primary find_btn" type="button" value="JOIN NOW">-->
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

	               for($i=0; $i<$item->no_of_seats; $i++)
	               { ?>
	                <div class="col-sm-2 seats">
	                	<img src="<?php echo JURI::base(); ?>/images/seat.jpg">
	                </div>
	               <?php } ?>
	            </div>
	                <div class="col-xs-0 no"><?php echo $item->no_of_seats; ?>&nbsp;<span class="s">Seats left</span></div>
	            </div>
	        </div>
    </div>

       	<?php }
        }?>
         <script type="text/javascript">
					jQuery(document).ready(function(){
						SqueezeBox.initialize({}); // Ajax Modal Pop
							SqueezeBox.assign($$('.results_list a.modal'), {
							parse: 'rel'
						});
					});
				</script>


     <?php exit;
    }


    public function pricerange()
    {
       $list=$_POST['list'];
       $model         = $this->getModel('postcabform');
       $combinelist   = $model->getlist($list);
       $count=count($combinelist);

       if($count<=0)
       {?>
       	  <div class="no_records">No records found</div>
       <?php }
       else
       {
       	foreach($combinelist as $i => $item)
       	{ ?>
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
								<?php echo $item->name; ?></a></b></h6>
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
						<a href="<?php echo JRoute::_('index.php?option=com_bookacab&view=bookcab&layout=popup&id='.$item->id.'&tmpl=component'); ?>" rel="{size: {x: 450, y: 400}, closable: true}" class="modal" id="find_cab">Join Now</a>
						<!--<input id="find_cab" class="btn btn primary find_btn" type="button" value="JOIN NOW">-->
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
       	<?php }
        }

     exit;
    }


    //Home page search values
    public function getsearchform()
	{
		$_SESSION['source']=$_POST['sourcepass'];
		$_SESSION['destination']=$_POST['destinationpass'];

		$user = JFactory::getUser();

		if(empty($user->id)){
			exit;
		}
		$name=$user->name;
		$email=$user->email;
		$mobile=$user->mobile;
		//echo $mobile;
		//exit;

	}

	//SMS Function Starts (book a cab popup->yes)
    public function getpostform()
	{
		$_SESSION['date']=$_POST['datepass'];
		$_SESSION['time']=$_POST['timepass'];
		$_SESSION['from']=$_POST['frompass'];
		$_SESSION['to']=$_POST['topass'];
		$_SESSION['cab_type']=$_POST['ctypepass'];

		$user = JFactory::getUser();

		if(empty($user->id)){
			exit;
		}

		$name=$user->name;
		$email=$user->email;
		$mobile=$user->mobile;
		//echo $mobile;
		//exit;

		$app = JFactory::getApplication();
        $config = JFactory::getConfig();
		$sitename=$config->get('sitename');

		$db = JFactory::getDbo();
		$sqldr='SELECT name,mobile from  #__users where cab_type="'.$_SESSION['cab_type'].'"';

		$db->setQuery($sqldr);
		$resdata=$db->loadObject();
		$drname=$resdata->name;
		$drmobile=$resdata->mobile;

		$db = JFactory::getDBO();
		$cabyes  = new stdClass();
		$cabyes->name=$name;
		$cabyes->mobile=$mobile;
		$cabyes->email=$email;
		$cabyes->date=date('Y-m-d',strtotime($_SESSION['date']));
		$cabyes->time=$_SESSION['time'];
		$cabyes->from=$_SESSION['from'];
		$cabyes->to=$_SESSION['to'];
		$cabyes->cab_type=$_SESSION['cab_type'];

		if(!($db->insertObject( '#__bookacab', $cabyes, 'id' )))
		{
			echo $db->stderr();
			return false;
		}
		else
		{
			$this->sms($name, $drname, $sitename, $mobile, $email, $_SESSION['cab_type'], $_SESSION['from'] ,$_SESSION['to']);
			$this->driversms($drname, $name, $sitename, $drmobile, $_SESSION['cab_type'], $_SESSION['from'] ,$_SESSION['to']);
			//$app->redirect(JRoute::_('index.php?option=com_sppagebuilder&view=page&id=1', false), $message);
			//header('Location: index.php?option=com_sppagebuilder&view=page&id=1');
		}
		exit;
		/*$message="";
        $app->redirect(JRoute::_('index.php', false), $message);*/
	}

	/* Method to send SMS for Users (Registered user book a cab->yes) */
	public function sms($uname, $drname, $sitename, $umobile, $email, $drcbtype, $destination, $source)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $phone = $umobile;
        //echo $phone;
        //exit;
        $text ="Hi $uname,\n  your Cab will be confirmed with in 15 mins from $destination to $source by $sitename";
		//echo  "$text \n";
		//exit;
        $priority ="ndnd";
        $stype = "normal";
        //extract data from the post
        extract($_POST);

        //set POST variables
        $url = 'http://bhashsms.com/api/sendmsg.php?';
        $fields = array(
			'user' => urlencode($user),
			'pass' => urlencode($pass),
			'sender' => urlencode($sender),
			'phone' => urlencode($phone),
			'text' => urlencode($text),
			'priority' =>urlencode($priority),
			'stype' => urlencode($stype)
        );

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

    /* Method to send SMS for Users (driver user book a cab->yes)  */
    public function driversms($drname,$name,$sitename,$mobilenum,$drcbtype,$destination,$source)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $mobilenum = $mobilenum;
        //echo $mobilenum;
        //exit;
        $text ="Hi $drname,\n $name looking for your cab from $destination to $source by $sitename";
		//echo $text;
        //exit;
        $priority ="ndnd";
        $stype = "normal";
        //extract data from the post
        extract($_POST);

        //set POST variables
        $url = 'http://bhashsms.com/api/sendmsg.php?';
        $fields = array(
			'user' => urlencode($user),
			'pass' => urlencode($pass),
			'sender' => urlencode($sender),
			'phone' => urlencode($mobilenum),
			'text' => urlencode($text),
			'priority' =>urlencode($priority),
			'stype' => urlencode($stype)
        );

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

	private function random_string($length) {
		$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'));

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $key;
	}


    //SMS Function Starts (Join now listing page)
	public function getjoinnow()
	{
	   $itemId=$_POST['itemId'];
       $seats=$_POST['seats'];
       $drname=$_POST['drname'];
       $drmobile=$_POST['drmobile'];
       $drfrom=$_POST['drfrom'];
       $drto=$_POST['drto'];
       $drcbtype=$_POST['drcbtype'];
       $uname=$_POST['uname'];
       $umobile=$_POST['umobile'];
       $confirmation=$_POST['confirm'];

        $token =  $this->random_string(16);
	    $token = bin2hex($token);

		//echo $token;

        $db = JFactory::getDbo();
	    $bookcab  = new stdClass();
	    $bookcab->post_id	      = $itemId;
	    $bookcab->seats	      = $seats;
	    $bookcab->name	      = $uname;
		$bookcab->from	      = $drfrom;
		$bookcab->to	      = $drto;
		$bookcab->cab_type	      = $drcbtype;
		$bookcab->mobile	      = $umobile;
		$bookcab->token	      = $token;
		if(!($db->insertObject( '#__bookacab', $bookcab, 'id' )))
		{
			echo $db->stderr();
			return false;
		}

	    $lastRowId = $db->insertid();
	    //echo $lastRowId;
	    $linkurl=JURI::root().'index.php?option=com_bookacab&view=postcabform&layout=confirmbook&tmpl=component&id='.$lastRowId.'&token='.$token;
	    ob_start();
        $this->joinsms($umobile,$uname);
        $this->joindriversms($drname,$uname,$seats,$drmobile,$linkurl);
		$output = ob_get_contents();
		ob_end_clean();


        $message="1";
	    echo $message;
	    exit;
	}

	public function updatephone(){
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$user = JFactory::getUser();
		$phone = JRequest::getVar("phone");
		if(!empty($phone) && strlen($phone) >= 10 && $user->id > 0){

			$user = &JFactory::getUser();
			$saveuser = new JUser($user->id);
			$saveuser->mobile = $phone;
			$saveuser->save();

			$this->setRedirect(JURI::root(),"Successfully Updated");
			return false;
		} else {
			$this->setRedirect("index.php?option=com_bookacab&view=postcabform&layout=phonenumber","Invalid details");
			return false;
		}
	}

    public function joinsms($umobile,$uname)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $phone = $umobile;
        $text ="Hi $uname Your cab will be confirm within 10 to 15min";

        $priority ="ndnd";
        $stype = "normal";
        //extract data from the post
        extract($_POST);

        //set POST variables
        $url = 'http://bhashsms.com/api/sendmsg.php?';
        $fields = array(
			'user' => urlencode($user),
			'pass' => urlencode($pass),
			'sender' => urlencode($sender),
			'phone' => urlencode($phone),
			'text' => urlencode($text),
			'priority' =>urlencode($priority),
			'stype' => urlencode($stype)
        );

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

    public function joindriversms($drname,$uname,$seats,$drmobile,$linkurl)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $mobilenum = $drmobile;
        $text ="Hi $drname Mr. $uname want to book $seats seats in your cab please confirm by clicking below link \n $linkurl";
        $priority ="ndnd";
        $stype = "normal";
        //extract data from the post
        extract($_POST);

        //set POST variables
        $url = 'http://bhashsms.com/api/sendmsg.php?';
        $fields = array(
			'user' => urlencode($user),
			'pass' => urlencode($pass),
			'sender' => urlencode($sender),
			'phone' => urlencode($mobilenum),
			'text' => urlencode($text),
			'priority' =>urlencode($priority),
			'stype' => urlencode($stype)
        );

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

	//Post a cab Listing page Join now.
	/*public function joinnow()
	{
		$config = JFactory::getConfig();
		$sitename=$config->get('sitename');
		$drname=$_POST['drname'];
		$drmobile=$_POST['drmobile'];
		$drcbtype=$_POST['drcbtype'];
		$uname=$_POST['uname'];
		$umobile=$_POST['umobile'];
		$destination=$_POST['from'];
		$source=$_POST['to'];
		if($this->sms($uname,$sitename,$umobile,$drcbtype,$destination,$source) && $this->driversms($drname,$sitename,$drmobile,$drcbtype,$destination,$source))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		exit;
	}*/

	public function cancelbook(){
		$this->setRedirect(JURI::root());
		return false;
	}

	public function confirmbook(){
		$id = JRequest::getInt("id");
		$token = JRequest::getVar("token");

		$db = JFactory::getDbo();
		$sqlval='SELECT * from  #__bookacab where id="'.$id.'" AND token="'.$token.'"';
		$db->setQuery($sqlval);
		$data = $db->loadObject();

		if(!empty($data) && $data->confirm == 0){
			$db = JFactory::getDbo();
			$sqlval='Update #__bookacab set confirm=1 where id="'.$id.'"';
			$db->setQuery($sqlval);
			$db->execute();

			$sqlval='Update #__postacab set no_of_seats = no_of_seats - '.$data->seats.' where id="'.$data->post_id.'"';
			$db->setQuery($sqlval);
			$db->execute();

			$this->confirmcabsms($data->name,$data->mobile);
			$this->setMessage("Booking as been confirmed");

		} elseif(!empty($data) && $data->confirm == 1) {
			$this->setRedirect(JURI::root(),"Already confirmed");
			return false;
		} else {
			$this->setRedirect(JURI::root(),"Invalid Token");
			return false;
		}

		$this->setRedirect(JURI::root());
	}

 /* Method to send SMS for Users (driver user book a cab->yes)  */
    public function confirmcabsms($name,$mobilenum)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $mobilenum = $mobilenum;
        //echo $mobilenum;
        //exit;
        $text ="Hi $name, Your booking has been confirmed";
		//echo $text;
        //exit;
        $priority ="ndnd";
        $stype = "normal";
        //extract data from the post
        extract($_POST);

        //set POST variables
        $url = 'http://bhashsms.com/api/sendmsg.php?';
        $fields = array(
			'user' => urlencode($user),
			'pass' => urlencode($pass),
			'sender' => urlencode($sender),
			'phone' => urlencode($mobilenum),
			'text' => urlencode($text),
			'priority' =>urlencode($priority),
			'stype' => urlencode($stype)
        );

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

}
