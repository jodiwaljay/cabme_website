<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Driver_details
 * @author     Tabrez ulla khan <tabrez@redwebdesign.in>
 * @copyright  Copyright (C) 2016. All rights reserved.
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
$lang->load('com_driver_details', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_driver_details/js/form.js');

/**/
?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-driverdetail').submit(function (event) {

			});


		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-driverdetail').submit(function (event) {

			});


		});
	}
</script>

<div class="driverdetail-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-driverdetail"
		  action="<?php echo JRoute::_('index.php?option=com_driver_details&task=driverdetail.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">

	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('duid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('duid'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('ducat'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('ducat'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('dname'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('dname'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('demail'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('demail'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('dmobile'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('dmobile'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('dpass'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('dpass'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('dgen'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('dgen'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('daddr'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('daddr'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('cab_no'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('cab_no'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('cab_type'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('cab_type'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('price_per_km'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('price_per_km'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('license_no'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('license_no'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('license_copy'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('license_copy'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('route_prefer'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('route_prefer'); ?></div>
	</div>				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','driver_details')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','driver_details')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-driverdetail").appendChild(input);
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
				   href="<?php echo JRoute::_('index.php?option=com_driver_details&task=driverdetailform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_driver_details"/>
		<input type="hidden" name="task"
			   value="driverdetailform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
