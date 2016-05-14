<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

defined('_JEXEC') or die;

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');

// Get the form fieldsets.
$fieldsets = $this->form->getFieldsets();
?>

<script type="text/javascript">
	/*Joomla.submitbutton = function(task)
	{
		if (task == 'settings.cancel' || document.formvalidator.isValid(document.id('settings-form'))) {
			Joomla.submitform(task, document.getElementById('settings-form'));
		} else {
			alert('<?php 
			//echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); 
			?>');
		}

	}*/
</script>


<form action="<?php echo JRoute::_('index.php?option=com_jetestimonial&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	<fieldset>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#testimonialsettings" data-toggle="tab"><?php echo JText::_('COM_JETESTIMONIAL_TESTIMONIAL_SETTINGS'); ?></a></li>
			<li><a href="#ordersettings" data-toggle="tab"><?php echo JText::_('COM_JETESTIMONIAL_FAQ_ORDERSETTINGS'); ?></a></li>
			<li><a href="#imagesettings" data-toggle="tab"><?php echo JText::_('COM_JETESTIMONIAL_FAQ_IMAGERESIZE'); ?></a></li>
			<li><a href="#categorysettings" data-toggle="tab"><?php echo JText::_('COM_JETESTIMONIAL_CATEGORY_SETTINGS'); ?></a></li>
			<li><a href="#pagination" data-toggle="tab"><?php echo JText::_('COM_JETESTIMONIAL_FAQ_PAGINATION'); ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="testimonialsettings">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('theme'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('theme'); ?></div>
				</div>
				<label title="<?php echo JText::_('COM_JETESTIMONIAL_THEMEPREVIEW_LABEL').'::'.JText::_('COM_JETESTIMONIAL_THEMEPREVIEW_LABEL_DESC'); ?>" class="hasTip" for="jform_theme_demo" id="jform_theme_demo-lbl">
					<?php echo JText::_('COM_JETESTIMONIAL_THEMEPREVIEW_LABEL'); ?>
				</label>
				<div id="je-themepreview">
					<?php echo JHTML::_('image','administrator/components/com_jetestimonial/assets/images/preview/'.$this->item->theme.'.jpg', JText::_('COM_TESTIMONIAL_STYLE').$this->item->theme, '', false)?>
				</div>
			</div>
			<div class="tab-pane" id="ordersettings">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('orderby'); ?></div>
					<div class="controls"><?php	echo $this->form->getInput('orderby'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('sortby'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('sortby'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('ordering_random'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('ordering_random'); ?></div>
				</div>				
			</div>
			<?php
				if($this->item->image_resize) {
					$style	= 'style="display : block;"';
				} else {
					$style	= 'style="display : none;"';
				}
			?>
			
			<div class="tab-pane" id="pagination">
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('show_pagination_jextn');?></div>
						<div class="controls"><?php	echo $this->form->getInput('show_pagination_jextn');?></div>		
				</div>
				<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('pagination_limit');?></div>
						<div class="controls"><?php	echo $this->form->getInput('pagination_limit');?></div>		
				</div>
			</div>
			
			<div class="tab-pane " id="imagesettings">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('image_resize'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('image_resize'); ?></div>
				</div>
				<div class="control-group" id="imgdimensions" <?php echo $style; ?>>
					<div class="control-label"><?php echo $this->form->getLabel('height'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('height'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('width'); ?></div>
					<div class="controls"><?php	echo $this->form->getInput('width'); ?></div>
				</div>
			</div>
			<?php
				if($this->item->image_resize) {
					$style	= 'style="display : block;"';
				} else {
					$style	= 'style="display : none;"';
				}
			?>
			<div class="tab-pane" id="categorysettings">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('show_image'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('show_image'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('image_position'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('image_position'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('show_introtext'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('show_introtext'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('cat_image_resize'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('cat_image_resize'); ?></div>
				</div>
				<div class="control-group" id="imgdimensions1" <?php echo $style; ?>>
					<div class="control-label"><?php echo $this->form->getLabel('cat_image_height'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('cat_image_height'); ?></div>
				</div>
				<div class="control-group" id="imgdimensions1" <?php echo $style; ?>>
					<div class="control-label"><?php echo $this->form->getLabel('cat_image_width'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('cat_image_width'); 	?></div>
				</div>
			</div>
	</fieldset>
	<input type="hidden" name="theme_path" id="theme_path" value="<?php echo JURI::base(); ?>"/>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div class="clr"></div>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>