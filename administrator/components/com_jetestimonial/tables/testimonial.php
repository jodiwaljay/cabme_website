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

class jetestimonialTableTestimonial extends JTable
{
	public function __construct(& $db)
	{
		parent::__construct( '#__jetestimonial_testimonials', 'id', $db );
	}

	/**
	 * Overloaded bind function
	 */
	public function bind($array, $ignore = '')
	{
		return parent::bind($array, $ignore);
	}

	/**
	 * Stores a faq
	 */
	public function store($updateNulls = false)
	{
		// Joomla predefined functions.
			$date									= & JFactory::getDate();
			$user									= & JFactory::getUser();
			$config									= JComponentHelper::getParams('com_jetestimonial');

		if ($this->id) {

			// Existing item
				$this->modified_date				= $date->toSql();
				$this->modified_by					= $user->get('username');

			// Capture ip Address
				if (empty($this->ip_address)) {
		         	$this->ip_address		 		= $_SERVER['REMOTE_ADDR'];
		        }

			// Get the old row
				$oldrow 							= JTable::getInstance('Testimonial', 'jetestimonialTable');
				if (!$oldrow->load($this->id) && $oldrow->getError()) {
					$this->setError($oldrow->getError());
				}

			// Change the order from old to new..
				if ($oldrow->published>=0 && ($this->published < 0 || $oldrow->catid != $this->catid)) {
					$this->ordering					= self::getNextOrder('`catid`=' . $this->_db->Quote($this->catid).' AND published>=0');
				}

			// Upload Avatar image
				$avatar_file						= JRequest::getVar( 'avatar_image', '', 'files', 'array' );
				$ava_image							= $avatar_file['name'];

				$video_file							= JRequest::getVar( 'jevideo', '', 'files', 'array' );
				$video_name							= $video_file['name'];

				$audio_file							= JRequest::getVar( 'jeaudio', '', 'files', 'array' );
				$audio_name							= $audio_file['name'];

				if (!empty($ava_image)) {
					$model	 						= JModelLegacy::getInstance('Testimonial', 'jetestimonialModel');
					$avatar_image					= $model->uploadAvatarimage( $avatar_file,$this->id );

					if(!empty($avatar_image)) {
						$this->avatar_image			= $avatar_image;
					}
				}
				if($video_name){
					$model	 						= JModelLegacy::getInstance('Testimonial', 'jetestimonialModel');
					$video_file						= $model->uploadVideo( $video_file );

					if(!empty($video_file)) {
						$this->lvideo				= $video_file;
					}
				}
				if($audio_name){
					$model	 						= JModelLegacy::getInstance('Testimonial', 'jetestimonialModel');
					$audio_file						= $model->uploadAudio( $audio_file );

					if(!empty($audio_file)) {
						$this->laudio				= $audio_file;
					}
				}

			parent::store($updateNulls);

			// Reorder the oldrow
				if ($oldrow->published>=0 && ($this->published < 0 || $oldrow->catid != $this->catid)) {
					$this->reorder('`catid`=' . $this->_db->Quote($oldrow->catid).' AND published>=0');
				}

		} else {

			if (!intval($this->posted_date)) {
				 $this->posted_date					= $date->toSql();
			}

			if (empty($this->language)) {
				$this->language						= '*';
	        }

			// Capture ip Address
		         if (empty($this->ip_address)) {
		         	$this->ip_address		 		= $_SERVER['REMOTE_ADDR'];
		         }

			// Set ordering to last if ordering was 0
				$this->ordering						= self::getNextOrder('`catid`=' . $this->_db->Quote($this->catid).' AND published>=0');

			// Upload Avatar image
				$avatar_file						= JRequest::getVar( 'avatar_image', '', 'files', 'array' );
				$ava_image							= $avatar_file['name'];

				$video_file							= JRequest::getVar( 'jevideo', '', 'files', 'array' );
				$video_name							= $video_file['name'];

				$audio_file							= JRequest::getVar( 'jeaudio', '', 'files', 'array' );
				$audio_name							= $audio_file['name'];

				if (!empty($ava_image)) {
					$model	 						= JModelLegacy::getInstance('Testimonial', 'jetestimonialModel');
					$avatar_image					= $model->uploadAvatarimage( $avatar_file,0 );

					if(!empty($avatar_image)) {
						$this->avatar_image			= $avatar_image;
					}
				}
				if($video_name){
					$model	 						= JModelLegacy::getInstance('Testimonial', 'jetestimonialModel');
					$video_file						= $model->uploadVideo( $video_file );

					if(!empty($video_file)) {
						$this->lvideo				= $video_file;
					}
				}
				if($audio_name){
					$model	 						= JModelLegacy::getInstance('Testimonial', 'jetestimonialModel');
					$audio_file						= $model->uploadAudio( $audio_file );

					if(!empty($audio_file)) {
						$this->laudio				= $audio_file;
					}
				}

			// Mail to Admin when user the post Testimonials
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jetestimonial'.DS.'helpers'.DS.'jetestimonial.php');
				$canDo 								= jetestimonialHelper::getActions();
				if ($canDo->get('core.admin')) {
				} else {
					if($config->get('auto_publish', 0)) {
						$this->published			= '1';
					}
				}

			parent::store($updateNulls);

			if ($canDo->get('core.admin')) {
			}else{
				if($config->get('send_admin', 1)) {
				$catid = $this->id;

				$model	= JModelLegacy::getInstance('Testimonial','jetestimonialModel');
				$model->mailtoAdmin( $this->email, $this->name, $this->title, $this->description, $catid );
				}
			}
		}

		// Attempt to store the data.
			return count($this->getErrors())== 0;
	}

	function check()
	{
		// Set alias
		$this->alias								= JApplication::stringURLSafe($this->alias);
		if (empty($this->alias)) {
			$this->alias							= JApplication::stringURLSafe($this->title);
		}

		if (trim($this->description) == '') {
			$this->setError(JText::_('COM_JETESTIMONIAL_DESCRIPTION_MUST_HAVE_TEXT'));
			return false;
		}

		return true;
	}
}
?>
