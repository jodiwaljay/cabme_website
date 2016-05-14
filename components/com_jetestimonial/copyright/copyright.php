<?php
/**
 * JE Membership package
 * @author JExtension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2011 - 2012 JExtension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$pathToXML_File = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jetestimonial' . DS . 'jetestimonial.xml';
$xml	 		= JFactory::getXML($pathToXML_File,$isFile = true);

$name 			= $xml->name;
$version 		= $xml->version;
$author 		= $xml->author;
$authorurl 		= $xml->authorUrl;

echo $name."&nbsp;".$version."&nbsp;-";
?>
<a href="http://www.jextn.com/" title="<?php echo JText::_('JE_DEVELOPED'); ?>" target="_blank">
	<?php echo JText::_('JE_DEVELOPED'); ?>
</a>