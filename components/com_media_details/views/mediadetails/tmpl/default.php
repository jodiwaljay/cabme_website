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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_media_details');
$canEdit    = $user->authorise('core.edit', 'com_media_details');
$canCheckin = $user->authorise('core.manage', 'com_media_details');
$canChange  = $user->authorise('core.edit.state', 'com_media_details');
$canDelete  = $user->authorise('core.delete', 'com_media_details');
?>

<form action="<?php echo JRoute::_('index.php?option=com_media_details&view=mediadetails'); ?>" method="post"
      name="adminForm" id="adminForm">

	<?php /*echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); */?>
	<div class="table-responsive mediaList">
	<table class="table table-striped" id="mediadetailList">
		<thead>
		<tr>
			<th class=''>
			<?php echo JHtml::_('grid.sort',  'COM_MEDIA_DETAILS_MEDIADETAILS_PUBLICATION_NAME', 'a.publication_name', $listDirn, $listOrder); ?>
			</th>
			<th class=''>
			<?php echo JHtml::_('grid.sort',  'COM_MEDIA_DETAILS_MEDIADETAILS_HEADLINE', 'a.headline', $listDirn, $listOrder); ?>
			</th>
			<th class=''>
			<?php echo JHtml::_('grid.sort',  'COM_MEDIA_DETAILS_MEDIADETAILS_SHORTDESC', 'a.shortdesc', $listDirn, $listOrder); ?>
			</th>
			<?php if ($canEdit || $canDelete): ?>
				<th class="center">
			<?php echo JText::_('COM_MEDIA_DETAILS_MEDIADETAILS_ACTIONS'); ?>
			</th>
			<?php endif; ?>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<!--<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>-->
		</tr>
		</tfoot>
		<tbody>
			<?php foreach ($this->items as $i => $item) : ?>
				<?php $canEdit = $user->authorise('core.edit', 'com_media_details'); ?>
				<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_media_details')): ?>
				<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
			<?php endif; ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td><img src="<?php echo JURI::root().$item->publication_image; ?>" alt="<?php echo $this->escape($item->publication_name); ?>" title="<?php echo $this->escape($item->publication_name); ?>"/></td>
				<td><a href="<?php echo $item->link; ?>"><?php echo $item->headline; ?></a></td>
				<td><?php echo $item->shortdesc; ?></td>
				<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_media_details&task=mediadetailform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
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
</div>
	<?php if ($canCreate) : ?>
		<!--<a href="<?php echo JRoute::_('index.php?option=com_media_details&task=mediadetailform.edit&id=0', false, 2); ?>"
		   class="btn btn-success btn-small">
		   <i class="icon-plus"></i>
			<?php echo JText::_('COM_MEDIA_DETAILS_ADD_ITEM'); ?></a>-->
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
		if (confirm("<?php echo JText::_('COM_MEDIA_DETAILS_DELETE_MESSAGE'); ?>")) {
			window.location.href = '<?php echo JRoute::_('index.php?option=com_media_details&task=mediadetailform.remove&id=', false, 2) ?>' + item_id;
		}
		<?php endif; ?>
	}
</script>


