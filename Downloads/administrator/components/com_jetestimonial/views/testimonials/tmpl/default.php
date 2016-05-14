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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');


// Load the tooltip behavior.
JHTML::_('script','system/multiselect.js',false,true);

$user		= JFactory::getUser();
$userId		= $user->get('id');

$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$canOrder	= $user->authorise('core.edit.state', 'com_jetestimonial.category');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder 	= $listOrder == 'ordering';
if ($saveOrder){
	$saveOrderingUrl = 'index.php?option=com_jetestimonial&task=testimonials.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'categoryList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();

$canDo		= jetestimonialHelper::getActions();
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$loggeduser = JFactory::getUser();
?>
<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_jetestimonial&view=testimonials'); ?>" method="post" name="adminForm" id="adminForm">

<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
			<div class="filter-select">
				<div id="filter-bar" class="btn-toolbar">
					<div class="filter-search btn-group pull-left">
						<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_JETESTIMONIAL_FILTER_SEARCH_DESC');?></label>
						<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_JETESTIMONIAL_SEARCH_IN_NAME'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_JETESTIMONIAL_SEARCH_IN_NAME'); ?>" />
					</div>
					<div class="btn-group pull-left">
						<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
						<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
					</div>
					<div class="btn-group pull-right hidden-phone">
						<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
						<?php echo $this->pagination->getLimitBox(); ?>
					</div>
					<div class="btn-group pull-right hidden-phone">
						<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
						<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
							<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
							<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
							<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
						</select>
					</div>
					<div class="btn-group pull-right hidden-phone">
						<label for="filter_published" class="element-invisible"><?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC');?></label>
						<select name="filter_published" id="filter_published" class="inputbox" onchange="this.form.submit()">
							<option value="">
								<?php echo JText::_('JOPTION_SELECT_PUBLISHED');?>
							</option>
							<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
						</select>
					</div>
					<div class="btn-group pull-right hidden-phone">
						<label for="filter_category_id" class="element-invisible"><?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC');?></label>
						<select name="filter_category_id" id="filter_category_id" class="inputbox" onchange="this.form.submit()">
							<option value="">
								<?php echo JText::_('JOPTION_SELECT_CATEGORY');?>
							</option>
							<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_jetestimonial'), 'value', 'text', $this->state->get('filter.category_id'));?>
						</select>
					</div>
					<div class="btn-group pull-right">
						<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
						<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
							<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
							<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
						</select>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>

			<table class="table table-striped" id="categoryList">
				<thead>
					<tr>
						<th width="1%" class="nowrap center hidden-phone">
							<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
						</th>
						<th width="1%"  class="hidden-phone">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>
						<th class="hidden-phone">
							<?php echo JHtml::_('grid.sort',  'COM_JETESTIMONIAL_TITLE', 'tm.title', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort',  'COM_JETESTIMONIAL_NAME', 'tm.name', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JCATEGORY', 'tm.catid', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort', 'Release Date', 'tm.releasedate', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort',  'COM_JETESTIMONIAL_IPADDRESS', 'tm.ip_address', $listDirn, $listOrder); ?>
						</th>
						<th width="5%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'tm.published', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'tm.ordering', $listDirn, $listOrder); ?>
							<?php if ($canOrder && $saveOrder) :?>
								<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'testimonials.saveorder'); ?>
							<?php endif; ?>
						</th>
						<th width="10%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'access_level', $listDirn, $listOrder); ?>
						</th>
						<th width="5%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'tm.language', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'tm.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$n = count($this->items);
					foreach ($this->items as $i => $item) :
						$ordering	= ($listOrder == 'ordering');
						$canCreate	= $this->user->authorise('core.create',		'com_jetestimonial.category.'.$item->catid);
						$canEdit	= $this->user->authorise('core.edit',		'com_jetestimonial.category.'.$item->catid);
						$canEditOwn	= $this->user->authorise('core.edit.own',	'com_jetestimonial.category.'.$item->catid);
						$canChange	= $this->user->authorise('core.edit.state',	'com_jetestimonial.category.'.$item->catid);
		?>
						<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->catid; ?>">
							<td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel	  = '';
									if (!$saveOrder) :
										$disabledLabel    = JText::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
										<i class="icon-menu"></i>
									</span>
									<input type="text" style="display:none" name="order[]" size="5"	value="<?php echo $item->ordering;?>" class="width-20 text-area-order" />
								<?php else : ?>
									<span class="sortable-handler inactive" >
										<i class="icon-menu"></i>
									</span>
								<?php endif; ?>
							</td>
							<td class="center">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
							<td>
								<?php
								if ($canEdit || $canEditOwn) :
								?>
									<span class="editlinktip hasTip" title="<?php echo addslashes(htmlspecialchars(JText::_('COM_JEFAQPRO_TOOLTIP_EDITTESTIMONIAL').'::'.$item->title)); ?>">
										<a href="<?php echo JRoute::_('index.php?option=com_jetestimonial&task=testimonial.edit&id='.(int) $item->id); ?>">
											<?php echo $item->title; ?>
										</a> &nbsp;
									</span>
									<p class="smallsub">
										<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?>
									</p>
								<?php
								endif;
								?>
							</td>
							<td align="center">
								<?php echo $item->name; ?>
							</td>
							<td align="center">
								<?php echo $item->category_title; ?>
							</td>
							<td align="center">
								<?php echo $item->releasedate; ?>
							</td>
							<td align="center">
								<?php echo $item->ip_address; ?>
							</td>
							<td align="center">
								<?php echo JHtml::_('jgrid.published', $item->published, $i, 'testimonials.', $canChange, 'cb'); ?>
							</td>
							<td class="order">
								<?php if ($canChange) : ?>
									<?php if ($saveOrder) :?>
										<?php if ($listDirn == 'asc') : ?>
											<span>
												<?php echo $this->pagination->orderUpIcon($i, ($item->catid == @$this->items[$i-1]->catid),'testimonials.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?>
											</span>
											<span>
												<?php echo $this->pagination->orderDownIcon($i, $n, ($item->catid == @$this->items[$i+1]->catid), 'testimonials.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?>
											</span>
										<?php elseif ($listDirn == 'desc') : ?>
											<span>
												<?php echo $this->pagination->orderUpIcon($i, ($item->catid == @$this->items[$i-1]->catid),'testimonials.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?>
											</span>
											<span>
												<?php echo $this->pagination->orderDownIcon($i, $n, ($item->catid == @$this->items[$i+1]->catid), 'testimonials.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?>
											</span>
										<?php endif; ?>
									<?php endif; ?>
									<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
									<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
								<?php else : ?>
									<?php echo $item->ordering; ?>
								<?php endif; ?>
							</td>
							<td align="center">
								<?php echo $item->access_level; ?>
							</td>
							<td class="center">
								<?php if ($item->language=='*'):?>
									<?php echo JText::alt('JALL','language'); ?>
								<?php else:?>
									<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
								<?php endif;?>
							</td>
							<td align="center">
								<?php echo $item->id; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="12">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
			</table>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="view" value="testimonials" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
	</div><!-- End content -->
</form>

<p class="copyright" align="center">
	<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
</p>