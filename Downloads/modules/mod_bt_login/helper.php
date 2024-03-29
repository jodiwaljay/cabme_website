<?php
/**
 * @package 	mod_bt_login - BT Login Module
 * @version		2.6.0
 * @created		April 2012

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2011 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.user.helper' );
class modbt_loginHelper
{
	public static function loadModule($name,$title){
		$module=JModuleHelper::getModule($name,$title);
		return JModuleHelper::renderModule($module);
	}
	public static function loadModuleById($id){
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
			$query->select('module,title');
			$query->from('#__modules');
			$query->where('#__modules.id='.$id);
			$db->setQuery((string)$query);
			$module = $db->loadObject();

			$module = JModuleHelper::getModule( $module->module,$module->title );

			$contents = JModuleHelper::renderModule ( $module);
			return $contents;
	}
	public static function getReturnURL($params, $type)
	{
		$app	= JFactory::getApplication();
		$router = $app->getRouter();
		$url = null;
		if ($itemid =  $params->get($type))
		{
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select($db->quoteName('link'));
			$query->from($db->quoteName('#__menu'));
			$query->where($db->quoteName('published') . '=1');
			$query->where($db->quoteName('id') . '=' . $db->quote($itemid));

			$db->setQuery($query);
			if ($link = $db->loadResult()) {
				if ($router->getMode() == JROUTER_MODE_SEF) {
					$url = 'index.php?Itemid='.$itemid;
				}
				else {
					$url = $link.'&Itemid='.$itemid;
				}
			}
		}
		if (!$url)
		{
			// stay on the same page
			$uri = clone JFactory::getURI();
			$vars = $router->parse($uri);
			unset($vars['lang']);
			if ($router->getMode() == JROUTER_MODE_SEF)
			{
				if (isset($vars['Itemid']))
				{
					$itemid = $vars['Itemid'];
					$menu = $app->getMenu();
					$item = $menu->getItem($itemid);
					unset($vars['Itemid']);
					if (isset($item) && $vars == $item->query) {
						$url = 'index.php?Itemid='.$itemid;
					}
					else {
						$url = 'index.php?'.JURI::buildQuery($vars).'&Itemid='.$itemid;
					}
				}
				else
				{
					$url = 'index.php?'.JURI::buildQuery($vars);
				}
			}
			else
			{
				$url = 'index.php?'.JURI::buildQuery($vars);
			}
		}

		return base64_encode($url);
	}

	public static function getType()
	{
		$user =  JFactory::getUser();
		return (!$user->get('guest')) ? 'logout' : 'login';
	}

	public static function getModules($params) {
		$user =  JFactory::getUser();
		if ($user->get('guest')) return '';

		$document = JFactory::getDocument();
		$moduleRender = $document->loadRenderer('module');
		$positionRender = $document->loadRenderer('modules');

		$html = '';

		$db = JFactory::getDbo();
		$i=0;
		$module_id = $params->get('module_id', array());
		if (count($module_id) > 0) {
			$sql = "SELECT * FROM #__modules WHERE id IN (".implode(',', $module_id).") ORDER BY ordering";
			$db->setQuery($sql);
			$modules = $db->loadObjectList();
			foreach ($modules as $module) {

				if ($module->module != 'mod_bt_login') {
					$i++;
					$html = $html . $moduleRender->render($module->module, array('title' => $module->title, 'style' => 'xhtml'));
					//$html = $html .$moduleRender->render($module->module, array('title' => $module->title, 'style' => 'rounded'));
					//if($i%2==0) $html.="<br clear='both'>";
				}
			}
		}
		$module_position = $params->get('module_position', array());
		if (count($module_position) > 0) {
			foreach ($module_position as $position) {
				$modules = JModuleHelper::getModules($position);
				foreach ($modules as $module) {
					if ($module->module != 'mod_bt_login') {
						$i++;
						$html = $html . $moduleRender->render($module, array('style' => 'xhtml'));
						//if($i%2==0) $html.="<br clear='both'>";
					}
				}
			}
		}
		if ($html==''){
			$html= $moduleRender->render('mod_menu',array('title'=>'User Menu','style'=>'xhtml'));
		}
		return $html;
	}
	public static function fetchHead($params){
		$document	= JFactory::getDocument();
		$header = $document->getHeadData();
		$mainframe = JFactory::getApplication();
		$template = $mainframe->getTemplate();

		$loadJquery = true;
		switch($params->get('loadJquery',"auto")){
			case "0":
				$loadJquery = false;
				break;
			case "1":
				$loadJquery = true;
				break;
			case "auto":

				foreach($header['scripts'] as $scriptName => $scriptData)
				{
					if(substr_count($scriptName,'/jquery'))
					{
						$loadJquery = false;
						break;
					}
				}
			break;
		}

		// load js
		if(file_exists(JPATH_BASE.'/templates/'.$template.'/html/mod_bt_login/js/default.js'))
		{
			if($loadJquery)
			{
				$document->addScript(JURI::root(true).'/templates/'.$template.'/html/mod_bt_login/js/jquery.min.js');
			}
			$document->addScript(JURI::root(true).'/templates/'.$template.'/html/mod_bt_login/js/jquery.simplemodal.js');
			$document->addScript(JURI::root(true).'/templates/'.$template.'/html/mod_bt_login/js/default.js');
		}
		else{
			if($loadJquery)
			{
				$document->addScript(JURI::root(true).'/modules/mod_bt_login/tmpl/js/jquery.min.js');
			}
			$document->addScript(JURI::root(true).'/modules/mod_bt_login/tmpl/js/jquery.simplemodal.js');
			$document->addScript(JURI::root(true).'/modules/mod_bt_login/tmpl/js/default.js');
		}

		// load css
		if(file_exists(JPATH_BASE.'/templates/'.$template.'/html/mod_bt_login/css/style2.0.css'))
		{
			$document->addStyleSheet(  JURI::root(true).'/templates/'.$template.'/html/mod_bt_login/css/style2.0.css');
		}
		else{
			$document->addStyleSheet(JURI::root(true).'/modules/mod_bt_login/tmpl/css/style2.0.css');
		}

		//bind JText to JS:
		JText::script('REQUIRED_FILL_ALL');
		JText::script('E_LOGIN_AUTHENTICATE');
		JText::script('REQUIRED_NAME');
		JText::script('REQUIRED_PROFILEPIC');
		JText::script('REQUIRED_USERNAME');
		JText::script('REQUIRED_PASSWORD');
		JText::script('REQUIRED_VERIFY_PASSWORD');
		JText::script('PASSWORD_NOT_MATCH');
		JText::script('REQUIRED_EMAIL');
		JText::script('REQUIRED_TEL');
		JText::script('EMAIL_INVALID');
		JText::script('REQUIRED_VERIFY_EMAIL');
		JText::script('EMAIL_NOT_MATCH');
		JText::script('CAPTCHA_REQUIRED');
	}
/**
	 *
	 * function register()
	 * @param array() $temp
	 */
	public static function register($temp)
	{

		$config = JFactory::getConfig();
		$db		= JFactory::getDbo();
		$params = JComponentHelper::getParams('com_users');

		// Initialise the table with JUser.
		$user = new JUser;

		// Merge in the registration data.
		foreach ($temp as $k => $v) {
			$data[$k] = $v;
		}
		$filename=$_POST['postpicname'];


		/*jimport('joomla.filesystem.file');
        $arr1=array("jpg","png","JPEG","jpeg");
		$jinput = JFactory::getApplication()->input;
		$files  = $jinput->files->get('jform');
		echo $file   = $files['profile_pic'];
		exit;
	    echo $filename = $file['name'];
	    echo $filename = explode('.', $file['name']);
	    $val=$filename[1];
	    $filename[0] = preg_replace("/[^A-Za-z0-9]/i", "-", $filename[0]);
	    echo $filename = md5(time()) . '-' . implode('.',$filename);
		exit;

	    $src = $file['tmp_name'];
		$dest = JPATH_ROOT . '/components/com_users/profilepic/' . $filename;

        if(in_array($val, $arr1))
        {
		  JFile::upload($src,$dest);
		  $data['profile_pic']=$filename;
		}*/


		// Prepare the data for the user object.
		$data['profile_pic']		= $filename;
		$data['email']		= $data['email1'];
		$data['password']	= $data['password1'];

		$data['mobile'] = JRequest::getVar('mobile');
		$useractivation = $params->get ( 'useractivation' );

		// Check if the user needs to activate their account.
		if (($useractivation == 1) || ($useractivation == 2)) {
			$data ['activation'] = JApplication::getHash ( JUserHelper::genRandomPassword () );
			$data ['block'] = 1;
		}
		$system	= $params->get('new_usertype', 2);
		$data['groups'] = array($system);

		// Bind the data.
		if (! $user->bind ( $data )) {
			self::ajaxResponse('$error$'.JText::sprintf ( 'COM_USERS_REGISTRATION_BIND_FAILED', $user->getError () ));
		}

		// Load the users plugin group.
		JPluginHelper::importPlugin('user');

		// Store the data.
		if (!$user->save()) {
			self::ajaxResponse('$error$'.JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
		}

		// Compile the notification mail values.
		$data = $user->getProperties();
		$data['fromname']	= $config->get('fromname');
		$data['mailfrom']	= $config->get('mailfrom');
		$data['sitename']	= $config->get('sitename');
		$data['siteurl']	= str_replace('modules/mod_bt_login/','',JURI::root());

		// Handle account activation/confirmation emails.
		if ($useractivation == 2)
		{
			// Set the link to confirm the user email.
			$data['activate'] = $data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'];

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);

		}
		elseif ($useractivation == 1)
		{
			// Set the link to activate the user account.
			$data['activate'] = $data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'];

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);


			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl'].'index.php?option=com_users&task=registration.activate&token='.$data['activation'],
				$data['siteurl'],
				$data['username'],
				$data['password_clear']
			);

		} else {

			$emailSubject	= JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBody = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_BODY',
				$data['name'],
				$data['sitename'],
				$data['siteurl']
			);
		}

		// Send the registration email.
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

		//Send Notification mail to administrators
		if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1)) {
			$emailSubject = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_BODY',
				$data['name'],
				$data['sitename']
			);

			$emailBodyAdmin = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY',
				$data['name'],
				$data['username'],
				$data['siteurl']
			);

			// get all admin users
			$query = 'SELECT name, email, sendEmail' .
					' FROM #__users' .
					' WHERE sendEmail=1';

			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			// Send mail to all superadministrators id
			foreach( $rows as $row )
			{
				JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

				// Check for an error.
				if ($return !== true) {
					//echo(JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED'));
				}
			}
		}
		// Check for an error.
		if ($return !== true) {
			//echo (JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));
			// Send a system message to administrators receiving system mails
			$db = JFactory::getDBO();
			$q = "SELECT id
				FROM #__users
				WHERE block = 0
				AND sendEmail = 1";
			$db->setQuery($q);
			$sendEmail = $db->loadColumn();
			if (count($sendEmail) > 0) {
				$jdate = new JDate();
				// Build the query to add the messages
				$q = "INSERT INTO ".$db->quoteName('#__messages')." (".$db->quoteName('user_id_from').
				", ".$db->quoteName('user_id_to').", ".$db->quoteName('date_time').
				", ".$db->quoteName('subject').", ".$db->quoteName('message').") VALUES ";
				$messages = array();

				foreach ($sendEmail as $userid) {
					$messages[] = "(".$userid.", ".$userid.", '".$jdate->toSql()."', '".JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')."', '".JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])."')";
				}
				$q .= implode(',', $messages);
				$db->setQuery($q);
				$db->query();
			}
		}


		if ($useractivation == 1)
			return "useractivate";
		elseif ($useractivation == 2)
			return "adminactivate";
		else
			return $user->id;
	}

	public static function ajax(){
		$mainframe =& JFactory::getApplication('site');
		//JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$bttask = JRequest::getVar('bttask');

		/**
		 * check task is login to do
		 */
		if($bttask=='login'){


				if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
					$return = base64_decode($return);
					if (!JURI::isInternal($return)) {
						$return = '';
					}
				}
				$options = array();

				$options['remember'] = JRequest::getBool('remember', false);

				$options['return'] = $return;

				$credentials = array();
				$pass =  JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);

				$credentials['username'] = JRequest::getVar('username', '', 'method', 'username');

				$credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);


				//preform the login action
				$error = $mainframe->login($credentials, $options);
				self::ajaxResponse($error);
		}elseif(($bttask=='register')) {
			/**
			 * check task is registration to do
			 */
			// If registration is disabled - Redirect to login page.
			if(JComponentHelper::getParams('com_users')->get('allowUserRegistration') == 0){
				// set message in here : Registration is disable
				self::ajaxResponse("Registration is not allow!");
			}

			//check captcha
			$enabledRecaptcha=JRequest::getVar('recaptcha');
			if($enabledRecaptcha=='yes'){
				if(JRequest::getVar('recaptcha_response_field')){
					$captcha = JCaptcha::getInstance('recaptcha');
					//$captcha->initialise('6Lf7Js8SAAAAAJBSx3JdwDKN0F1kVTF47Uz_DEli ');
					$checkCaptcha = $captcha->checkAnswer(JRequest::getVar('recaptcha_response_field'));
					if($checkCaptcha==false){
						self::ajaxResponse('$error$'.JText::_('PLG_RECAPTCHA_ERROR_INCORRECT_CAPTCHA_SOL'));
					}
				}elseif(JRequest::getString('btl_captcha')){
					$session = JFactory::getSession();
					echo $session->get('btl_captcha');
					if(JRequest::getString('btl_captcha') != $session->get('btl_captcha')){
						self::ajaxResponse('$error$'.JText::_('INCORRECT_CAPTCHA'));
					}
				}else{
					self::ajaxResponse('$error$'.JText::_('INCORRECT_CAPTCHA'));
				}
			}

			// Get the user data.
			// reset params form name in getVar function (not yet)
			$requestData ['name']= JRequest::getVar('name');
			$requestData ['username']= JRequest::getVar('username');
			$requestData ['password1']= JRequest::getVar('passwd1');
			$requestData ['password2']= JRequest::getVar('passwd2');
			$requestData ['email1']= JRequest::getVar('email1');
			$requestData ['email2']= JRequest::getVar('email2');

			// Save the data in the session.
			// may be use
			//$app->setUserState('com_users.registration.data', $requestData);


			// Attempt to save the data.
			$return	=self::register($requestData);
			if ($return === 'adminactivate'){
				self::ajaxResponse(JText::_('COM_USERS_REGISTRATION_COMPLETE_VERIFY'));
			} elseif ($return === 'useractivate') {
				self::ajaxResponse(JText::_('COM_USERS_REGISTRATION_COMPLETE_ACTIVATE'));
			} else {
				self::ajaxResponse(JText::_('COM_USERS_REGISTRATION_SAVE_SUCCESS'));
			}
		}else{
			self::ajaxResponse(self::createCaptcha());
		}
	}
	public static function ajaxResponse($message){
		$obLevel = ob_get_level();
		if($obLevel){
			while ($obLevel > 0 ) {
				ob_end_clean();
				$obLevel --;
			}
		}else{
			ob_clean();
		}
		echo $message;
		die;
	}

	/**
	 * Create image captcha
	 * @since 2.6.0
	 */
	public static function createCaptcha(){
		$session = JFactory::getSession();
		$oldImages = glob(JPATH_ROOT . '/modules/mod_bt_login/captcha_images/*.png');
		if($oldImages){
			foreach($oldImages as $oldImage){
				if(file_exists($oldImage)){
					unlink($oldImage);
				}
			}
		}
		// var_dump($session->get('btl_captcha_image_path'));
		// if($session->get('btl_captcha_image_path')){
			// $oldImage = JPATH_ROOT . '/modules/mod_bt_login/captcha_images/'. $session->get('btl_captcha_image_path');
			// var_dump(file_exists($oldImage));
			// if(file_exists($oldImage)){
				// unlink($oldImage);
			// }
		// }


		$imagePath = base64_encode($session->getId() . time()). '.png';
		$session->set('btl_captcha_image_path', $imagePath);

		$image = imagecreatetruecolor(200, 50) or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 0, 255, 255);
		$line_color = imagecolorallocate($image, 64, 64, 64);
		$pixel_color = imagecolorallocate($image, 0, 0, 255);
		imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

		//create 3 lines
		for ($i = 0; $i < 3; $i++) {
			imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
		}
		//random dots
		for ($i = 0; $i < 1000; $i++) {
		imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
		}

		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$len = strlen($letters);


		$text_color = imagecolorallocate($image, 0, 0, 0);
		$word = "";
		for ($i = 0; $i < 6; $i++) {
			$letter = $letters[rand(0, $len - 1)];
			imagestring($image, 7, 5 + ($i * 30), 20, $letter, $text_color);
			$word .= $letter;
		}
		$session->set('btl_captcha', $word);



		if(!file_exists(JPATH_ROOT . "/modules/mod_bt_login/captcha_images")){
			mkdir(JPATH_ROOT . "/modules/mod_bt_login/captcha_images");
		}

		imagepng($image, JPATH_ROOT . '/modules/mod_bt_login/captcha_images/' . $imagePath);
		return JURI::root(). 'modules/mod_bt_login/captcha_images/' . $imagePath;
	}
	/**
	 * Return builtin captcha html
	 * @since 2.6.0
	 */
	public static function getBuiltinCaptcha(){
		$html = '<img src="' . self::createCaptcha() .'" alt=""/>
				<div style="clear:both"></div>
				<input type="text" name="btl_captcha" id="btl-captcha" size="10"/>
				<span id="btl-captcha-reload" title="' . JText::_('RELOAD_CAPTCHA') . '">' . JText::_('RELOAD_CAPTCHA') . '</span>
				';
		return $html;
	}
}
