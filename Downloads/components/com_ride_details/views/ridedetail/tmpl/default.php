<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Ride_details
 * @author     demo <pncode.demo@gmail.com>
 * @copyright  2016 demo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_ride_details');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_ride_details')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_USERIMG'); ?></th>
			<td><?php echo $this->item->userimg; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_RIDES'); ?></th>
			<td><?php echo $this->item->rides; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_RATING'); ?></th>
			<td><?php echo $this->item->rating; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_DATE'); ?></th>
			<td><?php echo $this->item->date; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_TIME'); ?></th>
			<td><?php echo $this->item->time; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_SRCADDRESS'); ?></th>
			<td><?php echo $this->item->srcaddress; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_DSTADDRESS'); ?></th>
			<td><?php echo $this->item->dstaddress; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_PICKUPPOINT'); ?></th>
			<td><?php echo $this->item->pickuppoint; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_CARTYPE'); ?></th>
			<td><?php echo $this->item->cartype; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_ALLOWED'); ?></th>
			<td><?php echo $this->item->allowed; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_VERIFIED'); ?></th>
			<td><?php echo $this->item->verified; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_PRICE'); ?></th>
			<td><?php echo $this->item->price; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_RIDE_DETAILS_FORM_LBL_RIDEDETAIL_SEATS'); ?></th>
			<td><?php echo $this->item->seats; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_ride_details&task=ridedetail.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_RIDE_DETAILS_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_ride_details')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_ride_details&task=ridedetail.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_RIDE_DETAILS_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_RIDE_DETAILS_ITEM_NOT_LOADED');
endif;
