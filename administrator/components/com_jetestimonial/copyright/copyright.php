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
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

//$pathToXML_File = JURI::root() .'administrator/components/com_jetestimonial/jetestimonial.xml';
$pathToXML_File = JPATH_COMPONENT . '/jetestimonial.xml';
$xml	 		= JFactory::getXML($pathToXML_File,$isFile = true);
//$xml->loadFile($pathToXML_File);
$name 			= $xml->name;
$version 		= $xml->version;
$author 		= $xml->author;
$authorurl 		= $xml->authorUrl;

echo $name."&nbsp;".$version."&nbsp;-&nbsp;";
?>
<a href="http://www.jextn.com" title="<?php echo JText::_('JE_DEVELOPED'); ?>" target="_blank">
	<?php echo JText::_('JE_DEVELOPED'); ?>
</a>