<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Upload_resume
 * @author     Rekha <rekhakl@redwebdesign.in>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_upload_resume', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_upload_resume/js/form.js');

/**/
?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-resume').submit(function (event) {
				
		if(jQuery('#jform_select_image').val() != ''){
			jQuery('#jform_select_image_hidden').val(jQuery('#jform_select_image').val());
		}
		if (jQuery('#jform_select_image').val() == '' && jQuery('#jform_select_image_hidden').val() == '') {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			event.preventDefautl();
		}
			});

			
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-resume').submit(function (event) {
				
		if(jQuery('#jform_select_image').val() != ''){
			jQuery('#jform_select_image_hidden').val(jQuery('#jform_select_image').val());
		}
		if (jQuery('#jform_select_image').val() == '' && jQuery('#jform_select_image_hidden').val() == '') {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			event.preventDefautl();
		}
			});

			
		});
	}
</script>

<div class="resume-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-resume"
		  action="<?php echo JRoute::_('index.php?option=com_upload_resume&task=resume.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<?php echo $this->form->renderField('job_id'); ?>

	<?php echo $this->form->renderField('job_title'); ?>

	<?php echo $this->form->renderField('job_location'); ?>

	<?php echo $this->form->renderField('your_name'); ?>

	<?php echo $this->form->renderField('email_id'); ?>

	<?php echo $this->form->renderField('mobile_number'); ?>

	<?php echo $this->form->renderField('select_image'); ?>

	<?php if (!empty($this->item->select_image)) :
		foreach ((array) $this->item->select_image as $singleFile) : 
			if (!is_array($singleFile)) :
				echo '<a href="' . JRoute::_(JUri::root() . 'resume' . DIRECTORY_SEPARATOR . $singleFile, false) . '">' . $singleFile . '</a> ';
			endif;
		endforeach;
	endif; ?>
	<input type="hidden" name="jform[select_image][]" id="jform_select_image_hidden" value="<?php echo str_replace('Array,', '', implode(',', (array) $this->item->select_image)); ?>" />
	<?php echo $this->form->renderField('description'); ?>

	<?php echo $this->form->renderField('created_by'); ?>
				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','upload_resume')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','upload_resume')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-resume").appendChild(input);
                    });
                </script>
             <?php endif; ?>
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_upload_resume&task=resumeform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_upload_resume"/>
		<input type="hidden" name="task"
			   value="resumeform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
