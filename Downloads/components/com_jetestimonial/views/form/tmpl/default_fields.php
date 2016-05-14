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

	require_once (JPATH_COMPONENT.DS.'captcha'.DS.'captcha.php');
?>

<fieldset>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label">	<?php echo $this->form->getLabel('catid'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
		<div class="clr"></div>
		<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
	</div>
	<div class="clr"></div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
	</div>
	<?php
	if($this->params->get('email', 1)) {
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
	</div>
	<?php
	}
	if($this->params->get('companyname', 1)) {
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('companyname'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('companyname'); ?></div>
	</div>
	<?php
	}

	if($this->params->get('city', 1)) {
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('city'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('city'); ?></div>
	</div>
	<?php
	}

	if($this->params->get('state', 1)) {
	?>
		<div class="control-group">
			<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
		</div>
	<?php
	}

	if($this->params->get('country', 1)) {
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('country'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('country'); ?></div>
	</div>
	<?php
	}

	if($this->params->get('website', 1)) {
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('website'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('website'); ?></div>
	</div>
	<?php
	}

	if($this->params->get('avatar', 1)) {
	?>

	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('avatar_image'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('avatar_image'); ?></div>
	</div>
	<?php
	}
	if($this->params->get('enable_audio', 1)){
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('laudio'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('laudio'); ?></div>
	</div>
	<?php }
	if($this->params->get('enable_video', 1))
	if($this->params->get('video', 1)) {
	?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('video'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('video'); ?></div>
	</div>
	<?php }else{
		?>
		<div class="control-group">
			<div class="control-label"><?php echo $this->form->getLabel('lvideo'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('lvideo'); ?></div>
		</div>
		<?php
	}
	if($this->params->get('release_date', 1)) {
	?>
		<div class="control-group">
			<div class="control-label"><?php echo $this->form->getLabel('releasedate'); ?></div>
			<div class="controls"><?php echo $this->form->getInput('releasedate'); ?></div>
		</div>
	<?php
	}
	if( $this->params->get('captcha_show', 1) ) { ?>
		<div class="control-group">
			<div class="control-label">
				<label title="" class="hasTip" for="jform_captcha" id="jform_captcha-lbl">
					<?php echo JText::_('JETESTIMONIAL_CAPTCHA')." :"; echo '<span style="color:#CC0000;">*</span>';?>
				</label>
			</div>
			<div class="controls">
				<?php echo(AutarticaptchaHelper::generateInputTags());?>
				<?php echo(AutarticaptchaHelper::generateImgTags(JURI::Base()."components/com_jetestimonial/captcha/"));?>
				<?php echo(AutarticaptchaHelper::generateHiddenTags());?>
			</div>
		</div>
	<?php } ?>

	<div class="form-actions">
		<button  type="button" class="btn btn-primary validate" onclick="Joomla.submitbutton('testimonial.save')">
			<?php echo JText::_('JSAVE') ?>
		</button>
		<button type="button" class="btn btn-primary validate" onclick="Joomla.submitbutton('testimonial.cancel')">
			<?php echo JText::_('JCANCEL') ?>
		</button>
	</div>
</fieldset>

<?php if ( $this->item->params->get('access-edit') != '' ) { ?>
	<fieldset>
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
	</fieldset>
<?php } ?>