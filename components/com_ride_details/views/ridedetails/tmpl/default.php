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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_ride_details');
$canEdit    = $user->authorise('core.edit', 'com_ride_details');
$canCheckin = $user->authorise('core.manage', 'com_ride_details');
$canChange  = $user->authorise('core.edit.state', 'com_ride_details');
$canDelete  = $user->authorise('core.delete', 'com_ride_details');
?>

<form action="<?php echo JRoute::_('index.php?option=com_ride_details&view=ridedetails'); ?>" method="post"
      name="adminForm" id="adminForm">

	<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table table-striped" id="ridedetailList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				<th width="5%">
	<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_USERIMG', 'a.userimg', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_RIDES', 'a.rides', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_RATING', 'a.rating', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_SRCADDRESS', 'a.srcaddress', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_DSTADDRESS', 'a.dstaddress', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_PICKUPPOINT', 'a.pickuppoint', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_CARTYPE', 'a.cartype', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_VERIFIED', 'a.verified', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_PRICE', 'a.price', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_RIDE_DETAILS_RIDEDETAILS_SEATS', 'a.seats', $listDirn, $listOrder); ?>
				</th>


							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_RIDE_DETAILS_RIDEDETAILS_ACTIONS'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_ride_details'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_ride_details')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
	<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_ride_details&task=ridedetail.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
	<?php if ($item->state == 1): ?>
		<i class="icon-publish"></i>
	<?php else: ?>
		<i class="icon-unpublish"></i>
	<?php endif; ?>
	</a>
</td>
				<?php endif; ?>

								<td>

					<?php echo $item->id; ?>
				</td>
				<td>

					<?php echo $item->userimg; ?>
				</td>
				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'ridedetails.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_ride_details&view=ridedetail&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->name); ?></a>
				</td>
				<td>

					<?php echo $item->rides; ?>
				</td>
				<td>

					<?php echo $item->rating; ?>
				</td>
				<td>

					<?php echo $item->srcaddress; ?>
				</td>
				<td>

					<?php echo $item->dstaddress; ?>
				</td>
				<td>

					<?php echo $item->pickuppoint; ?>
				</td>
				<td>

					<?php echo $item->cartype; ?>
				</td>
				<td>

					<?php echo $item->verified; ?>
				</td>
				<td>

					<?php echo $item->price; ?>
				</td>
				<td>

					<?php echo $item->seats; ?>
				</td>


								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_ride_details&task=ridedetailform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_ride_details&task=ridedetailform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_RIDE_DETAILS_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {
		var item_id = jQuery(this).attr('data-item-id');
		<?php if($canDelete) : ?>
		if (confirm("<?php echo JText::_('COM_RIDE_DETAILS_DELETE_MESSAGE'); ?>")) {
			window.location.href = '<?php echo JRoute::_('index.php?option=com_ride_details&task=ridedetailform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


