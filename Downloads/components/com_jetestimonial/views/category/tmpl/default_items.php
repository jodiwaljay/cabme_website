<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined('_JEXEC') or die;

JHtmlBehavior::framework();

$n = count($this->items);
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');

if (empty($this->items)) {
?>
	<p>
		<?php echo JText::_('COM_JETESTIMONIAL_ERROR_TESTIMONIALS_NOT_FOUND'); ?>
	</p>
<?php
}
else {
?>

<div id="je-faqpro">
	<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">
		<?php
			echo $this->loadTemplate('testimonials');
			echo $this->loadTemplate('testimonialspagination');
		?>

		<div>
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<input type="hidden" name="limitstart" value="" />
		</div>
	</form>
</div>
<?php
}
?>