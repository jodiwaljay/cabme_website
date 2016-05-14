<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

jimport('joomla.filesystem.folder');

class jetestimonialModelTestimonial extends JModelAdmin
{
		/**
	 * Method to test whether a record can be deleted.
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		if ($record->catid) {
			return $user->authorise('core.delete', 'com_jetestimonial.testimonial.'.(int) $record->catid);
		} else {
			return parent::canDelete($record);
		}
	}

	/**
	 * Method to test whether a record can be deleted.
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		// Check against the category.
			if (!empty($record->catid)) {
				return $user->authorise('core.edit.state', 'com_jetestimonial.testimonial.'.(int) $record->catid);
			}
		// Default to component settings if category not known.
			else {
				return parent::canEditState($record);
			}
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 */
	public function getTable($type = 'Testimonial', $prefix = 'JetestimonialTable', $config = array())
{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the row form.
	 */
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');

		// Get the form.
			$form	= $this->loadForm('com_jetestimonial.testimonial', 'testimonial', array('control' => 'jform', 'load_data' => $loadData));
			if (empty($form)) {
				return false;
			}

		// Modify the form based on access controls.
			if (!$this->canEditState((object) $data)) {
				// Disable fields for display.
					$form->setFieldAttribute('ordering', 'disabled', 'true');
					$form->setFieldAttribute('published', 'disabled', 'true');
					$form->setFieldAttribute('access', 'disabled', 'true');
					$form->setFieldAttribute('language', 'disabled', 'true');

				// Disable fields while saving.
				// The controller has already verified this is a record you can edit.
					$form->setFieldAttribute('ordering', 'filter', 'unset');
					$form->setFieldAttribute('published', 'filter', 'unset');
					$form->setFieldAttribute('access', 'filter', 'unset');
					$form->setFieldAttribute('language', 'filter', 'unset');
			}

		return $form;
	}

	/**
	 * Method to get a single record.
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);

		return $item;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
			$data					= JFactory::getApplication()->getUserState('com_jetestimonial.edit.testimonial.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('testimonial.id') == 0) {
				$app = JFactory::getApplication();
				$data->set('catid', JRequest::getInt('catid', $app->getUserState('com_jetestimonial.testimonials.filter.category_id')));
			}
		}

		return $data;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 */
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->name		= htmlspecialchars_decode($table->name, ENT_QUOTES);
		$table->alias		= JApplication::stringURLSafe($table->alias);


		if (empty($table->alias)) {
			$table->alias = JApplication::stringURLSafe($table->name);
		}


		if ($table->id == 0) {
			 //Set ordering to the last item if not set
			if (empty($table->ordering)) {

				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query = "SELECT MAX(ordering) FROM #__jetestimonial_testimonials";
				$db->setQuery($query);
				$max = $db->loadResult();

				$table->ordering = $max+1;
			}
		} else {
			// Set the values
//			$table->modified_date	= JFactory::getDate()->toSql();
//			$table->modified_by		= $user->get('id');
		}

	}

	/**
	 * A protected method to get a set of ordering conditions.
	 */
	/*protected function getReorderConditions($table)
	{
		$condition		= array();
		$condition[]	= 'catid = '.(int) $table->catid;
		$condition[]	= 'published >= 0';

		return $condition;
	}

	public function reorder($pks, $delta = 0)
	{
		// Clear the component's cache
		$cache = JFactory::getCache();
		$cache->clean('com_jetestimonial');

		return parent::reorder($pks, $delta);
	}*/

	public function mailtoAdmin( $email, $name, $title, $describtion, $catid )
	{
		$app							= JFactory::getApplication();

		$config							= JComponentHelper::getParams('com_jetestimonial');
		$id								= $catid;
		$url							= JURI::root()."index.php?option=com_jetestimonial&task=testimonial.activate&tid=".$id;
		$url_active						="<a href=".$url.">Click to active link.</a>";

		$to								= $app->getCfg('mailfrom');
		$sett_to						= $config->get('emailid');
		$recipients 					= array($sett_to);

		//Multiple mail received 
		foreach($recipients as $multi_mailrec){
			echo $multi_mailrec;
		}
		$recipients_mail				= explode(',', $multi_mailrec);
		//end
		$from		= $email;
		$name		= $name;
		$site		= $app->getCfg('sitename'); //outputs sitename

		$sender 	= array( $from, $name );
		$mailer 	= & JFactory::getMailer();
		$mailer->setSender( $sender );

		if ( $sett_to == 'admin@emailid.com' || $sett_to == '' ) {
			$to		= $app->getCfg('mailfrom');  //outputs mailfrom
			$mailer->addRecipient($to);
		} else {
			foreach($recipients_mail as $multiple_mail){
			$mailer->addRecipient($multiple_mail); // outputs Multiple Mail 
			}
		}

		$subject 	= sprintf ( JText::_( 'JE_TESTFROM' ), $site );
		$subject 	= html_entity_decode($subject, ENT_QUOTES);

		$message 	= sprintf ( JText::_( 'JE_NEWMAIL' ),$title, $describtion, $url_active ,$name );
		$message 	= html_entity_decode($message, ENT_QUOTES);

		$mailer->setSubject( $subject );
		$mailer->setBody( $message );

		$mailer->IsHTML(true);

		if ($mailer->Send() == true) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the category name.
	 */
	protected function getCategoryName( $catid )
	{
		if ($catid) {
			$db			= $this->getDbo();
			$query		= $db->getQuery(true);
			$query->select('title');
			$query->from('`#__categories`');
			$query->where('`id`='.$db->quote($catid));
			$db->setQuery((string)$query);
			$name		= $db->loadResult();

			if ($db->getErrorNum()) {
				$this->setError($db->getErrorMsg());
				return false;
			}
		} else {
			$name		= JText::_('COM_BANNERS_NOCATEGORYNAME');
		}

		return $name;
	}

	/*public function uploadAvatarimage( $cert_file )
	{
		$upload_directory = JPATH_SITE .DS.'images'.DS.'jeavatar';
		if (isset($cert_file['name'])  && $cert_file['name'] != '') {

			$format  	 = strtolower(JFile::getExt($cert_file['name']));
    		$date  		 =& JFactory::getDate();
			$file_name	 = time().".".$format;
			$cert_filepath_new = $upload_directory . DS . $file_name;

			// Check whether the file in an image format..
			if($format != "jpeg" && $format != "jpg" && $format != "png" && $format != "gif") {
				$msg = JText::_('JE_NOTSAVED');
				JError::raiseWarning(100, $msg );

				return false;
			} else {
				if (!JFile::upload($cert_file['tmp_name'], $cert_filepath_new)) {
					$msg 	= JText::_('JE_NOTUPLOADED');
					JError::raiseWarning(500, $msg);

					return false;
				} else {
					$newfilename	= "thumb_";
					$settings		= $this->getSettings();

					if( $settings->image_resize ){
						$resize_height	= $settings->height ? $settings->height : '100';
						$resize_width	= $settings->width ? $settings->width : '100' ;
						$resize			= $this->resize( $file_name, $cert_filepath_new, $newfilename, $resize_width, $resize_height);

						if(!$resize) {
							return false;
						} else {
							return $resize;
						}
					} else {
						return $file_name;
					}
				}
			}
		}
	}

	public function resize( $file_name, $filename,$newfilename,$newwidth,$newheight ){
		//Searched image name string to select Extension
			$image_type 			= strtolower(JFile::getExt($file_name));

		//SWITCHES THE IMAGE CREATE FUNCTION BASED ON FILE EXTENSION
			switch($image_type) {
				case 'jpg':
				case 'jpeg':
					$source			= @imagecreatefromjpeg($filename);
					break;
				case 'png':
					$source			= @imagecreatefrompng($filename);
					break;
				case 'gif':
					$source			= @imagecreatefromgif($filename);
					break;
				default:
					echo("Error Invalid Image Type");
					$msg 			= JText::_('JE_INVALIDTYPE');
					JError::raiseWarning(500, $msg);

					return false;
					break;
			}

			if(!$source) {
				return false;
			}

		// Creates the name of the saved file
			$file					= $newfilename.$file_name;

		// Creates the path to the saved file
			$path					= JPATH_SITE .DS.'images'.DS.'jeavatar';

			if( !JFolder::exists($path) ) {
				JFolder::create($path);
			}

			$fullpath				= $path.DS.$file;

		// Finds size of the old file
			list($width, $height)	= getimagesize($filename);

		// Creates image with new sizes
			$thumb					= imagecreatetruecolor($newwidth, $newheight);

		// Resizes old image to new sizes
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		// Saves image and sets quality || Numerical value = Quality on scale of 1-100
			imagejpeg($thumb, $fullpath, 60);

		// Creating filename to write to database
			$filepath				= $fullpath;

		// Returns full filepath of image ends function
		return $file;
	}*/

	public function getSettings(){
		$id					= 1;
		$settings  			= JTable::getInstance('Settings', 'JetestimonialTable');
		$settings->load($id);

		return $settings;
	}
	public function uploadVideo( $video_file ){
		$user					= JFactory::getUser();
		$upload_directory 		= JPATH_SITE .DS.'components'.DS.'com_jetestimonial'.DS.'assets'.DS.'videos';
		if (isset($video_file['name'])  && $video_file['name'] != '') {
			$format  	 		= strtolower(JFile::getExt($video_file['name']));
    		$date  		 		=& JFactory::getDate();
    		$time_name			= time();
			$file_name	 		= $time_name.".".$format;

			$cert_filepath_new 	= $upload_directory . DS . $file_name;
			$cert_filepath_flv 	= $upload_directory;
			if($format != "mp4" && $format != "flv" && $format != "avi" && $format != "3gp") {
				$msg = JText::_('JE_NOTSAVED');
				JError::raiseWarning(100, $msg );

				return false;
			} else {
				if (!JFile::upload($video_file['tmp_name'], $cert_filepath_new)) {
					$msg 	= JText::_('JE_NOTUPLOADED');
					JError::raiseWarning(500, $msg);
					return false;
				} else {
					$flv_name = $cert_filepath_flv.DS.$time_name.'.flv';
					$flv_save = $time_name.'.flv';
					$convert_status = $this->convertToFlv($cert_filepath_new,$flv_name);
					if($convert_status == true){
						return $flv_save;
					}else{
						return $file_name;
					}
				}
			}
		}
	}
	function convertToFlv( $input, $output ){
	   $ffmpeg 				='/usr/bin/ffmpeg';
	   $command = "$ffmpeg -i $input -s 320x240 -ar 44100 -r 12 $output";
	   shell_exec( $command );
	   return true;
	}
	public function uploadAudio( $audio_file ){
		$user					= JFactory::getUser();
		$upload_directory 		= JPATH_SITE .DS.'components'.DS.'com_jetestimonial'.DS.'assets'.DS.'audios';
		if (isset($audio_file['name'])  && $audio_file['name'] != '') {
			$format  	 		= strtolower(JFile::getExt($audio_file['name']));
    		$date  		 		=& JFactory::getDate();
    		$time_name			= time();
			$file_name	 		= $time_name.".".$format;

			$cert_filepath_new 	= $upload_directory . DS . $file_name;
			$cert_filepath_flv 	= $upload_directory;
			if($format != "mp3") {
				$msg = JText::_('JE_NOTSAVED_AUDIO');
				JError::raiseWarning(100, $msg );

				return false;
			} else {
				if (!JFile::upload($audio_file['tmp_name'], $cert_filepath_new)) {
					$msg 	= JText::_('JE_NOTUPLOADED');
					JError::raiseWarning(500, $msg);
					return false;
				} else {
//					$flv_name = $cert_filepath_flv.DS.$time_name.'.flv';
//					$flv_save = $time_name.'.flv';
//					$convert_status = $this->convertToFlv($cert_filepath_new,$flv_name);
//					if($convert_status == true){
						return $file_name;
//					}else{
//						return $file_name;
//					}
				}
			}
		}
	}
	/* upload avatar starts */
	public function uploadAvatarimage( $cert_file, $id ){
		$upload_directory 				= JPATH_SITE .DS.'images'.DS.'jeavatar';
		if (isset($cert_file['name'])  && $cert_file['name'] != '') {

			$format  	 				= strtolower(JFile::getExt($cert_file['name']));
    		$date  		 				=& JFactory::getDate();
			$file_name	 				= time().".".$format;
			$cert_filepath_new 			= $upload_directory . DS . $file_name;

			// Check whether the file in an image format..
			if($format != "jpeg" && $format != "jpg" && $format != "png" && $format != "gif") {
				$msg 					= JText::_('JE_NOTSAVED');
				JError::raiseWarning(100, $msg );

				return false;
			} else {
				if (!JFile::upload($cert_file['tmp_name'], $cert_filepath_new)) {
					$msg 				= JText::_('JE_NOTUPLOADED');
					JError::raiseWarning(500, $msg);

					return false;
				} else {
					$newfilename		= "thumb_";
					$settings			= $this->getSettings();

					if( $settings->image_resize ){
						$mysock 		= getimagesize($cert_filepath_new);
						$targetOb		= $this->getSettings();
						$target			= $targetOb->height;

						/*MEDiUM*/
						$newfilename_medium		= "mediumthumb_";
						$target_medium	= 500;
						$size_medium 			= $this->imageResize($mysock[0], $mysock[1], $target_medium);
						$size_medium 			= explode(",",$size_medium);

						$resize_height_medium 	= $size_medium[1];
						$resize_width_medium 	= $size_medium[0];
						$resize			= $this->resize( $mysock,$file_name, $cert_filepath_new, $newfilename_medium, $resize_width_medium, $resize_height_medium, $id, $target_medium);
						/*MEDiUM ends*/

						$size 			= $this->imageResize($mysock[0], $mysock[1], $target);
						$size 			= explode(",",$size);

						$resize_height 	= $size[1];
						$resize_width 	= $size[0];

						$resize			= $this->resize( $mysock,$file_name, $cert_filepath_new, $newfilename, $resize_width, $resize_height, $id, $target);

						if(!$resize) {
							return false;
						} else {
							return $resize;
						}
					} else {
						return $file_name;
					}
				}
			}
		}
	}

	public function resize( $image, $file_name, $filename,$newfilename,$newwidth,$newheight, $id, $target ){
		//Searched image name string to select Extension
		$image_type 			= strtolower(JFile::getExt($file_name));

		//SWITCHES THE IMAGE CREATE FUNCTION BASED ON FILE EXTENSION
		switch($image_type) {
			case 'jpg':
			case 'jpeg':
				$source			= @imagecreatefromjpeg($filename);
				$imgtype		= 'jpg';
				break;
			case 'png':
				$source			= @imagecreatefrompng($filename);
				$imgtype		= 'png';
				break;
			case 'gif':
				$source			= @imagecreatefromgif($filename);
				$imgtype		= 'gif';
				break;
			default:
				echo("Error Invalid Image Type");
				$msg 			= JText::_('JE_INVALIDTYPE');
				JError::raiseWarning(500, $msg);

				return false;
				break;
		}

		if(!$source) {
			return false;
		}

		// Creates the name of the saved file
		$file					= $newfilename.$file_name;

		// Creates the path to the saved file
		$path					= JPATH_SITE .DS.'images'.DS.'jeavatar';

		if( !JFolder::exists($path) ) {
			JFolder::create($path);
		}

		$fullpath				= $path.DS.$file;

		// Finds size of the old file
		list($width, $height)	= getimagesize($filename);

		if($image[0]>$target && $image[1]>$target)
		{
			// Calculate measurements
		    if( $image[0] > $image[1] ) {
		        // For landscape images
		        $x_offset 		= ($image[0] - $image[1]) / 2;
		        $y_offset 		= 0;
		        $square_size 	= $image[0] - ($x_offset * 2);
		    } else {
		        // For portrait and square images
		        $x_offset 		= 0;
		        $y_offset 		= ($image[1] - $image[0]) / 2;
		        $square_size 	= $image[1] - ($y_offset * 2);
		    }

		    // Resize and crop
		    $thumb 				= imagecreatetruecolor($newwidth,$newheight);
		    imagealphablending($thumb, false);
			imagesavealpha($thumb,true);
			$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
			imagefilledrectangle($thumb, 0, 0, $newwidth, $newheight, $transparent);
		    if( imagecopyresampled(
		        $thumb,
		        $source,
		        0,
		        0,
		        0,
		        0,
		        $newwidth,
		        $newheight,
		        $image[0],
		        $image[1]
		    )) {
		    	if($imgtype=='jpg')
		    		imagejpeg($thumb, $fullpath, 100);
		    	if($imgtype=='gif')
		    		imagegif($thumb, $fullpath);
		    	if($imgtype=='png')
		    		imagepng($thumb, $fullpath);
		    }
		} else {
			$thumb 				= imagecreatetruecolor($image[0],$image[1]);
			imagealphablending($thumb, false);
			imagesavealpha($thumb,true);
			$transparent 		= imagecolorallocatealpha($thumb, 255, 255, 255, 127);
			imagefilledrectangle($thumb, 0, 0, $image[0], $image[1], $transparent);
			if( imagecopyresampled(
		        $thumb,
		        $source,
		        0,
		        0,
		        0,
		        0,
		        $image[0],
		        $image[1],
		        $image[0],
		        $image[1]
		    )) {
		    	if($imgtype=='jpg')
		    		imagejpeg($thumb, $fullpath, 100);
		    	if($imgtype=='gif')
		    		imagegif($thumb, $fullpath);
		    	if($imgtype=='png')
		    		imagepng($thumb, $fullpath);
		    }
		}

		$oldimagename 			= $this->getOldAvatarName($id);
		$oldimag 				= $oldimagename->avatar_image;
		$oldimg 				= explode("_",$oldimag);
		if($oldimag){
			if(JFile::exists(JPATH_ROOT.DS.'images'.DS.'jeavatar'.DS.$oldimg[1]))
				JFile::delete(JPATH_ROOT.DS.'images'.DS.'jeavatar'.DS.$oldimg[1]);
			/*MEDIUM*/
			if(JFile::exists(JPATH_ROOT.DS.'images'.DS.'jeavatar'.DS.'mediumthumb_'.$oldimg[1]))
				JFile::delete(JPATH_ROOT.DS.'images'.DS.'jeavatar'.DS.'mediumthumb_'.$oldimg[1]);
			/*MEDIUM END*/
			if(JFile::exists(JPATH_ROOT.DS.'images'.DS.'jeavatar'.DS.$oldimagename->avatar_image))
				JFile::delete(JPATH_ROOT.DS.'images'.DS.'jeavatar'.DS.$oldimagename->avatar_image);
		}

		// Creating filename to write to database
		$filepath				= $fullpath;

		// Returns full filepath of image ends function
		return $file;
	}

	function imageResize($width, $height, $target){
		if ($width > $height) {
			$percentage = ($target / $width);
		} else {
			$percentage = ($target / $height);
		}

		//gets the new value and applies the percentage, then rounds the value
		$width 			= round($width * $percentage);
		$height 		= round($height * $percentage);

		return "$width,$height";

	}


	public function getOldAvatarName($id){
		$settings  			= JTable::getInstance('Testimonial', 'jetestimonialTable');
		$settings->load($id);

		return $settings;
	}
}
?>
