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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jetestimonial&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="contact-form" class="form-validate" enctype="multipart/form-data">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend>
				<?php echo empty($this->item->id) ? JText::_('COM_JETESTIMONIAL_NEW_TESTIMONIAL') : JText::sprintf('COM_JETESTIMONIAL_EDIT_TESTIMONIAL', $this->item->id); ?>
			</legend>
			<ul class="adminformlist">
				<li>
					<?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?>
				</li>
			</ul>

			<div class="clr"></div>

			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('description'); ?>
		</fieldset>
	</div>

	<div class="width-40 fltrt">

		<?php
		$texts		= empty($this->item->id) ? JText::_('COM_JETESTIMONIAL_NEW_TESTIMONIAL_CLIENTOPTIONS') : JText::sprintf('COM_JETESTIMONIAL_EDIT_TESTIMONIAL_CLIENTOPTIONS', $this->item->id);

		echo  JHtml::_('sliders.start', 'jetestimonial-clientoptions-slider');
			echo JHtml::_('sliders.panel',JText::_($texts), 'jetestimonial-clientoptions');
		?>

			<fieldset class="panelform">
				<ul class="adminformlist">
					<li>
						<?php echo $this->form->getLabel('name'); ?>
						<?php echo $this->form->getInput('name'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('email'); ?>
						<?php echo $this->form->getInput('email'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('companyname'); ?>
						<?php echo $this->form->getInput('companyname'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('city'); ?>
						<?php echo $this->form->getInput('city'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('country'); ?>
						<?php echo $this->form->getInput('country'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('website'); ?>
						<?php echo $this->form->getInput('website'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('avatar_image'); ?>
						<?php echo $this->form->getInput('avatar_image'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('laudio'); ?>
						<?php echo $this->form->getInput('laudio'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('video'); ?>
						<?php echo $this->form->getInput('video'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('lvideo'); ?>
						<?php echo $this->form->getInput('lvideo'); ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('releasedate'); ?>
						<?php echo $this->form->getInput('releasedate'); ?>
					</li>
			    </ul>
		    </fieldset>
		<?php
		echo JHtml::_('sliders.end');

		$texts		= empty($this->item->id) ? JText::_('COM_JETESTIMONIAL_NEW_TESTIMONIAL_OPTIONS') : JText::sprintf('COM_JETESTIMONIAL_EDIT_TESTIMONIAL_OPTIONS', $this->item->id);

		echo  JHtml::_('sliders.start', 'jetestimonial-options-slider');
			echo JHtml::_('sliders.panel',JText::_($texts), 'jetestimonial-options');
		?>

			<fieldset class="panelform">
				<ul class="adminformlist">
					<li>
						<?php echo $this->form->getLabel('catid'); ?>
						<?php echo $this->form->getInput('catid'); ?>
					</li>

					<li>
						<?php echo $this->form->getLabel('published'); ?>
						<?php echo $this->form->getInput('published'); ?>
					</li>

					<li>
						<?php echo $this->form->getLabel('access'); ?>
						<?php echo $this->form->getInput('access'); ?>
					</li>

					<li>
						<?php echo $this->form->getLabel('language'); ?>
						<?php echo $this->form->getInput('language'); ?>
					</li>

					<li>
						<?php echo $this->form->getLabel('ordering'); ?>
						<?php echo $this->form->getInput('ordering'); ?>
					</li>
			    </ul>
		    </fieldset>
	      <?php echo JHtml::_('sliders.end'); ?>
	</div>

	<input type="hidden" name="task" value="testimonial.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div class="clr"></div>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>