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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'testimonial.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		} else {
			//alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}

	}
</script>
<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
	<?php echo $this->loadTemplate('title'); ?>

	<dl id="system-message" style="display : none">
		<dd class="warning message">
			<ul>
				<li><div id="je-error-message"></div></li>
			</ul>
		</dd>
	</dl>

	<form action="<?php echo JRoute::_('index.php?option=com_jetestimonial&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
		<?php echo $this->loadTemplate('fields'); ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
		<input type="hidden" name="je-errorwarning-message" id="je-errorwarning-message" value="<?php echo JText::_('COM_JETESTIMONIAL_VALIDATION_FORM_FAILED'); ?>"/>

		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>

<?php
if($this->params->get('show_footertext', 1)) {
?>
	<p class="copyright" style="text-align : right; font-size : 10px;">
		<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
	</p>
<?php
}
?>