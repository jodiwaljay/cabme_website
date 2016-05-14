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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_bookacab');
$canEdit    = $user->authorise('core.edit', 'com_bookacab');
$canCheckin = $user->authorise('core.manage', 'com_bookacab');
$canChange  = $user->authorise('core.edit.state', 'com_bookacab');
$canDelete  = $user->authorise('core.delete', 'com_bookacab');
?>

<form action="<?php echo JRoute::_('index.php?option=com_bookacab&view=bookcabs'); ?>" method="post"
      name="adminForm" id="adminForm">


	<table class="table table-striped" id="bookcabList">
		<thead>
			<tr>
				<?php if (isset($this->items[0]->state)): ?>
					<th width="5%"> <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?> </th>
				<?php endif; ?>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_ID', 'a.id', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_DATE', 'a.date', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_TIME', 'a.time', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_FROM', 'a.from', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_TO', 'a.to', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'Cab Type', 'a.cab_type', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_NAME', 'a.name', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_EMAIL', 'a.email', $listDirn, $listOrder); ?> </th>
					<th class=''> <?php echo JHtml::_('grid.sort',  'COM_BOOKACAB_BOOKCABS_MOBILE', 'a.mobile', $listDirn, $listOrder); ?> </th>
					<?php if ($canEdit || $canDelete): ?>
						<th class="center">	<?php echo JText::_('COM_BOOKACAB_BOOKCABS_ACTIONS'); ?> </th>
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
				<?php $canEdit = $user->authorise('core.edit', 'com_bookacab'); ?>
				<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_bookacab')): ?>
				<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
			<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">
				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
						<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_bookacab&task=bookcab.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
							<?php if ($item->state == 1): ?>
								<i class="icon-publish"></i>
							<?php else: ?>
								<i class="icon-unpublish"></i>
							<?php endif; ?>
						</a>
					</td>
				<?php endif; ?>

				<td><?php echo $item->id; ?></td>
				<td><?php echo $item->date; ?></td>
				<td><?php echo $item->time; ?></td>
				<td>
					<?php if (isset($item->checked_out) && $item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'bookcabs.', $canCheckin); ?>
					<?php endif; ?>
					<a href="<?php echo JRoute::_('index.php?option=com_bookacab&view=bookcab&id='.(int) $item->id); ?>"> <?php echo $this->escape($item->from); ?></a>
				</td>
				<td><?php echo $item->to; ?></td>
				<td><?php echo $item->cab_type; ?></td>
				<td><?php echo $item->name; ?></td>
				<td><?php echo $item->email; ?></td>
				<td><?php echo $item->mobile; ?></td>

					<?php if ($canEdit || $canDelete): ?>
				<td class="center">
					<?php if ($canEdit): ?>
						<a href="<?php echo JRoute::_('index.php?option=com_bookacab&task=bookcabform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
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
		<a href="<?php echo JRoute::_('index.php?option=com_bookacab&task=bookcabform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_BOOKACAB_ADD_ITEM'); ?></a>
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
		if (confirm("<?php echo JText::_('COM_BOOKACAB_DELETE_MESSAGE'); ?>")) {
			window.location.href = '<?php echo JRoute::_('index.php?option=com_bookacab&task=bookcabform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


