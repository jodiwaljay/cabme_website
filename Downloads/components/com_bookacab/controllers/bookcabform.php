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
 * Bookcab controller class.
 *
 * @since  1.6
 */
class BookacabControllerBookcabForm extends JControllerForm
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
		$previousId = (int) $app->getUserState('com_bookacab.edit.bookcab.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_bookacab.edit.bookcab.id', $editId);

		// Get the model.
		$model = $this->getModel('BookcabForm', 'BookacabModel');

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
		$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=bookcabform&layout=edit', false));
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
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('BookcabForm', 'BookacabModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();

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
			$app->setUserState('com_bookacab.edit.bookcab.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.bookcab.id');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=bookcabform&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_bookacab.edit.bookcab.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.bookcab.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=bookcabform&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		//SMS Function Starts
		if ($return)
		{
			$config = JFactory::getConfig();
			$sitename=$config->get('sitename');
			$name = $data['name'];
			$phone = $data['mobile'];
			$cabtype = $data['cab_type'];
			$emailid = $data['email'];
			$destination = $data['from'];
			$source	= $data['to'];
			$bookingnum = $return;
			$this->sms($name,$sitename,$phone,$emailid,$cabtype,$bookingnum,$destination,$source);

			$contacts = $model->getContact($cabtype);
			foreach($contacts as $res)
			{
				//print_r ($contacts);
				//exit;
                $mobilenum=$res->mobile;
                $drivername=$res->name;
                $drivercab=$res->cab_type;
                $config = JFactory::getConfig();
				$sitename=$config->get('sitename');
				$bookingnum = $return;
				//$destination = $res->from;
				//$source	= $res->to;
                /*echo $mobilenum;
                echo $drivername;
                echo $drivercab;
                echo $sitename;
                echo $bookingnum;
                exit;*/
                $this->driversms($drivername,$sitename,$mobilenum,$name,$drivercab,$name,$destination,$source);
			}
			//exit;
		}

		// Clear the profile id from the session.
		$app->setUserState('com_bookacab.edit.bookcab.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('Thankyou for Booking a Cab. Soon you Will receive a confirmation message to your registered mobile number'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_sppagebuilder&view=page&id=1' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_bookacab.edit.bookcab.data', null);
	}


	/* Method to send SMS for Users  */
	public function sms($name,$sitename,$phone,$emailid,$cabtype,$bookingnum,$destination,$source)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $phone = $phone;
        $text ="Hi $name,\n  your Cab will be confirmed with in 15 mins from $destination to $source by $sitename";
		//echo  "$text \n";
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

	/* Method to send SMS for Driver */
	public function driversms($drivername,$sitename,$mobilenum,$name,$drivercab,$bookingnum,$destination,$source)
    {
	    $user = "8890605392";
        $pass = "58cb94a";
        $sender = "ABHYAS";
        $mobilenum = $mobilenum;
        $text ="Hi $drivername,\n $name looking for your cab from $destination to $source by $sitename";
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
		$editId = (int) $app->getUserState('com_bookacab.edit.bookcab.id');

		// Get the model.
		$model = $this->getModel('BookcabForm', 'BookacabModel');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_bookacab&view=bookcabs' : $item->link);
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
		$model = $this->getModel('BookcabForm', 'BookacabModel');

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
			$app->setUserState('com_bookacab.edit.bookcab.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.bookcab.id');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=bookcab&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->delete($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_bookacab.edit.bookcab.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_bookacab.edit.bookcab.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_bookacab&view=bookcab&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_bookacab.edit.bookcab.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_BOOKACAB_ITEM_DELETED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_bookacab&view=bookcabs' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_bookacab.edit.bookcab.data', null);
	}
	public function rate()
	{
		$units=5;
		$id_sent = preg_replace("/[^0-9]/","",$_REQUEST['id']);
		$vote_sent = preg_replace("/[^0-9]/","",$_REQUEST['stars']);
		$user = JFactory::getuser();
		$usr_id = $user->id;
		$ip =$usr_id ;
		$db = &JFactory::getDBO();
		$query = "SELECT id  FROM #__ratings WHERE id=$id_sent";
		$db->setQuery($query);
		$rates = $db->loadResult();

		if(!$rates){
		$db = &JFactory::getDBO();
		$query2 = "INSERT INTO #__ratings (`id`,`date`) VALUES ($id_sent,curdate())";
		$db->setQuery($query2);
		$db->query();
		}

		//connecting to the database to get some information
		$db = &JFactory::getDBO();
		$query = "SELECT total_votes, total_value, used_ips  FROM #__ratings WHERE id=$id_sent";
		$db->setQuery($query);
		$rates2 = $db->loadobject();

		$checkIP = unserialize($rates2->used_ips);
		$checkIP2 = unserialize($rates2->used_ips);

		//$count = $numbers['total_votes']; //how many votes total
		$count = $rates2->total_votes; //how many votes total

		$current_rating = $rates2->total_value; //total number of rating added together and stored
		$sum = $vote_sent+$current_rating; // add together the current vote value and the total vote value
		$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote

		// checking to see if the first vote has been tallied
		// or increment the current number of votes
		($sum==0 ? $added=0 : $added=$count+1);

		// if it is an array i.e. already has entries the push in another value
		((is_array($checkIP)) ? array_push($checkIP,$ip) : $checkIP=array($ip));

		$insertip= serialize($checkIP);

		//IP check when voting

				$db = &JFactory::getDBO();
				$query = "SELECT  used_ips  FROM #__ratings WHERE used_ips LIKE '%".$ip."%' AND id='".$id_sent."' ";
				$db->setQuery($query);
				$voted = $db->loadResult();

		if(!$voted) {     //if the user hasn't yet voted, then vote normally...

			if (($vote_sent >= 1 && $vote_sent <= $units)) { // keep votes within range, make sure IP matches

				/*$update = "UPDATE $rating_tableName SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."' WHERE id='$id_sent'";
				$result = mysql_query($update);*/
				//if($result)	setcookie("rating_".$id_sent,1, time()+ 2592000);
				$db = &JFactory::getDBO();
				$query2 = "UPDATE  #__ratings SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."' WHERE id='$id_sent'";
				$db->setQuery($query2);
				$db->query();
			}
		} //end for the "if(!$voted)"
		// these are new queries to get the new values!

		$db = &JFactory::getDBO();
		$query = "SELECT  total_votes, total_value, used_ips  FROM #__ratings  WHERE id='".$id_sent."' ";
		$db->setQuery($query);
		$res2 = $db->loadobject();

		$count =$res2->total_votes;
		$current_rating =$res2->total_value;
		$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote

		// $new_back is what gets 'drawn' on your page after a successful 'AJAX/Javascript' vote
		if($voted){$sum=$current_rating; $added=$count;}
		$new_back = array();
		for($i=0;$i<5;$i++){
			$j=$i+1;
			if($i<@number_format($current_rating/$count,1)-0.5) $class="ratings_stars ratings_vote";
			else $class="ratings_stars";
			$new_back[] .= '<div class="star_'.$j.' '.$class.'"></div>';
		}

		$new_back[] .= ' <div class="total_votes"><p class="voted"> Rating: <strong>'.@number_format($sum/$added,1).'</strong>/'.$units.' ('.$count.' '.$tense.' cast) ';
		if(!$voted)$new_back[] .= '<span class="thanks">Thanks for voting!</span></p>';
		else {$new_back[] .= '<span class="invalid">Already voted for this item</span></p></div>';}
		$allnewback = join("\n", $new_back);
		$output = $allnewback;
		echo $output;
		exit;
	}
}
