<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Bookacab
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
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
$lang->load('com_bookacab', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_bookacab/js/form.js');

/**/
?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-postcab').submit(function (event) {

			});


		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-postcab').submit(function (event) {

			});


		});
	}
</script>

<div class="postcab-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-postcab"
		  action="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcab.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">

	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<?php if(empty($this->item->modified_by)): ?>
		<input type="hidden" name="jform[modified_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[modified_by]" value="<?php echo $this->item->modified_by; ?>" />
	<?php endif; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('mobile'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('mobile'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('cab_type'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('cab_type'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('from'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('from'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('to'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('to'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('date'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('date'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('time'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('time'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('pickuppoints'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('pickuppoints'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('rate_perkm'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('rate_perkm'); ?></div>
	</div>
		<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('rate_perkm'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('rate_perkm'); ?></div>
	</div>
		<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('rate_perkm'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('rate_perkm'); ?></div>
	</div>
		<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('rate_perkm'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('rate_perkm'); ?></div>
	</div>

	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('no_of_seats'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('no_of_seats'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('image_file'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('image_file'); ?></div>	
	</div>





					<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','bookacab')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','bookacab')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-postcab").appendChild(input);
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
				   href="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcabform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_bookacab"/>
		<input type="hidden" name="task"
			   value="postcabform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
