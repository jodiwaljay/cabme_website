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
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'testimonial.cancel' || document.formvalidator.isValid(document.id('contact-form'))) {
			Joomla.submitform(task, document.getElementById('contact-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}

	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_jetestimonial&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="contact-form" class="form-validate form-horizontal" enctype="multipart/form-data">
	<fieldset>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_('COM_JETESTIMONIAL_NEW_TESTIMONIAL') : JText::sprintf('COM_JETESTIMONIAL_EDIT_TESTIMONIAL', $this->item->id); ?></a></li>
			<li><a href="#clientoption" data-toggle="tab"><?php echo  JText::_('COM_JETESTIMONIAL_NEW_TESTIMONIAL_CLIENTOPTIONS'); ?></a></li>
			<li><a href="#options" data-toggle="tab"><?php echo JText::_('COM_JETESTIMONIAL_NEW_TESTIMONIAL_OPTIONS'); ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
				</div>
			</div>
			<div class="tab-pane" id="clientoption">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('companyname'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('companyname'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('city'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('city'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('country'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('country'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('website'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('website'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('avatar_image'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('avatar_image'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('laudio'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('laudio'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('video'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('video'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('lvideo'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('lvideo'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('releasedate'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('releasedate'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('posted_date'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('posted_date'); ?></div>
				</div>

			 </div>
			 <div class="tab-pane" id="options">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('access'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('access'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('language'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('language'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('ordering'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('ordering'); ?></div>
				</div>
			  </div>
		</div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<div class="clr"></div>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>