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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_driver_details.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_driver_details' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>


<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_DNAME'); ?></th>
			<td><?php echo $this->item->dname; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_DEMAIL'); ?></th>
			<td><?php echo $this->item->demail; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_DMOBILE'); ?></th>
			<td><?php echo $this->item->dmobile; ?></td>
</tr>


<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_DGEN'); ?></th>
			<td><?php echo $this->item->dgen; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_DADDR'); ?></th>
			<td><?php echo $this->item->daddr; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_CAB_NO'); ?></th>
			<td><?php echo $this->item->cab_no; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_CAB_TYPE'); ?></th>
			<td><?php echo $this->item->cab_type; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_PRICE_PER_KM'); ?></th>
			<td><?php echo $this->item->price_per_km; ?></td>
</tr>

<tr>
			<th><?php echo JText::_('COM_DRIVER_DETAILS_FORM_LBL_DRIVERDETAIL_ROUTE_PREFER'); ?></th>
			<td><?php echo $this->item->route_prefer; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_driver_details&task=driverdetail.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_DRIVER_DETAILS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_driver_details.driverdetail.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_driver_details&task=driverdetail.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_DRIVER_DETAILS_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_DRIVER_DETAILS_ITEM_NOT_LOADED');
endif;
