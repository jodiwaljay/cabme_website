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

$lvideo  	= JRequest::getInt('lvideo');
$laudio  	= JRequest::getInt('laudio');
$v 			= $this->video->video;

$play 		= explode("=", $v, 2);
$js_file 	= JURI::ROOT().'components/com_jetestimonial/assets/includes/swfobject.js';
$swf_file 	= JURI::ROOT().'components/com_jetestimonial/assets/includes/mpw_player.swf';
//echo $this->video->avatar_image;
$thumb 		= explode('thumb_',$this->video->avatar_image);
//echo "<pre>";print_r($this);echo "</pre>";exit;
?>
<script src="<?php echo $js_file; ?>" type="text/javascript"></script>
<?php
if($laudio){
	?>
	<body id="dewbody">
		<object type="application/x-shockwave-flash" data="components/com_jetestimonial/assets/audios/dewplayer-vol.swf?mp3=components/com_jetestimonial/assets/audios/<?php echo $this->video->laudio; ?>" width="240" height="20" id="dewplayer-vol"><param name="wmode" value="transparent" /><param name="movie" value="components/com_jetestimonial/assets/audios/dewplayer-vol.swf?mp3=mp3/<?php echo $this->video->laudio; ?>" /></object>
	</body>
	<?php
}else{
	?>
<div class="popup">
<?php
	if($lvideo){
	?>
	<div id="flvplayer">
		<img src="<?php echo JURI::ROOT().'images/jeavatar/'.$this->video->avatar_image; ?>" width="100%">
	</div>
	<script type="text/javascript">
		var so = new SWFObject("<?php echo $swf_file; ?>", "swfplayer", "530", "350", "9", "#000000"); // Player loading
		so.addVariable("flv", "<?php echo JURI::ROOT().'components/com_jetestimonial/assets/videos/'.$this->video->lvideo; ?>"); // File Name
		so.addVariable("jpg","<?php echo JURI::ROOT().'images/jeavatar/'.$this->video->avatar_image; ?>"); // Preview photo
		so.addVariable("autoplay","false"); // Autoplay, make true to autoplay
		so.addParam("allowFullScreen","true"); // Allow fullscreen, disable with false
		so.addVariable("backcolor","000000"); // Background color of controls in html color code
		so.addVariable("frontcolor","ffffff"); // Foreground color of controls in html color code
		so.write("flvplayer"); // This needs to be the name of the div id
	</script>
	<?php }else{ ?>
	<object>
		<param name="movie" value="http://www.youtube.com/v/<?php  echo $play[1]; ?>?fs=1&amp;hl=en_US&amp;rel=0">
		<param name="allowFullScreen" value="true">
		<param name="allowscriptaccess" value="always">
		<embed type="application/x-shockwave-flash" src="http://www.youtube.com/v/<?php  echo $play[1]; ?>?fs=1&amp;hl=en_US&amp;rel=0" mce_src="http://www.youtube.com/v/<?php  echo $play[1]; ?>?fs=1&amp;hl=en_US&amp;rel=0" allowscriptaccess="always" id="videoobject" allowfullscreen="true">
	</object>
	<?php }
 ?>
</div>
<?php } ?>
