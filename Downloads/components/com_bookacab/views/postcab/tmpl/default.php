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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_bookacab.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_bookacab' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_MOBILE'); ?></th>
			<td><?php echo $this->item->mobile; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_EMAIL'); ?></th>
			<td><?php echo $this->item->email; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_CAB_TYPE'); ?></th>
			<td><?php echo $this->item->cab_type; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_FROM'); ?></th>
			<td><?php echo $this->item->from; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_TO'); ?></th>
			<td><?php echo $this->item->to; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_DATE'); ?></th>
			<td><?php echo $this->item->date; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_TIME'); ?></th>
			<td><?php echo $this->item->time; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_PICKUPPOINTS'); ?></th>
			<td><?php echo $this->item->pickuppoints; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_RATE_PERKM'); ?></th>
			<td><?php echo $this->item->rate_perkm; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_BOOKACAB_FORM_LBL_POSTCAB_NO_OF_SEATS'); ?></th>
			<td><?php echo $this->item->no_of_seats; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcab.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_BOOKACAB_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_bookacab.postcab.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_bookacab&task=postcab.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_BOOKACAB_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_BOOKACAB_ITEM_NOT_LOADED');
endif;
