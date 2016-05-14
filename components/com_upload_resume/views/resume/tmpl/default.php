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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_upload_resume.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_upload_resume' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_JOB_ID'); ?></th>
			<td><?php echo $this->item->job_id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_JOB_TITLE'); ?></th>
			<td><?php echo $this->item->job_title; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_JOB_LOCATION'); ?></th>
			<td><?php echo $this->item->job_location; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_YOUR_NAME'); ?></th>
			<td><?php echo $this->item->your_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_EMAIL_ID'); ?></th>
			<td><?php echo $this->item->email_id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_MOBILE_NUMBER'); ?></th>
			<td><?php echo $this->item->mobile_number; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_SELECT_IMAGE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->select_image as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'resume' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_DESCRIPTION'); ?></th>
			<td><?php echo $this->item->description; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_UPLOAD_RESUME_FORM_LBL_RESUME_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_upload_resume&task=resume.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_UPLOAD_RESUME_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_upload_resume.resume.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_upload_resume&task=resume.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_UPLOAD_RESUME_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_UPLOAD_RESUME_ITEM_NOT_LOADED');
endif;
