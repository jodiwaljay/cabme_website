<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Media_details
 * @author     Tabrez ulla khan <tabrez@redwebdesign.in>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_media_details.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_media_details' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_PUBLICATION_NAME'); ?></th>
			<td><?php echo $this->item->publication_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_PUBLICATION_IMAGE'); ?></th>
			<td><?php echo $this->item->publication_image; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_HEADLINE'); ?></th>
			<td><?php echo $this->item->headline; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_LINK'); ?></th>
			<td><?php echo $this->item->link; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_MEDIA_DETAILS_FORM_LBL_MEDIADETAIL_SHORTDESC'); ?></th>
			<td><?php echo $this->item->shortdesc; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_media_details&task=mediadetail.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_MEDIA_DETAILS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_media_details.mediadetail.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_media_details&task=mediadetail.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_MEDIA_DETAILS_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_MEDIA_DETAILS_ITEM_NOT_LOADED');
endif;
