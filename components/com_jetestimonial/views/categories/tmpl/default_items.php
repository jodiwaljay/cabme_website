<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/
// no direct access
defined('_JEXEC') or die('Restricted Access');
$path	 	= JURI::root();
$tempid	  	= $this->settings->theme;
$doc	 	= JFactory::getDocument();
$cparams 	= JComponentHelper::getParams('com_media');
$class		= ' class="first"';
$empty_categories_if	= 0;
$empty_categories_else	= 0;
$n    = count($this->items[$this->parent->id]);
if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) {
?>
<body>
<form action="<?php echo JRoute::_('index.php?option=com_jetestimonial&view=categories'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="contentarea" style="text-align : justify;">
	<table width="100%" align="center" cellpadding="2" class="contentpane<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" >
		<?php
		foreach($this->items[$this->parent->id] as $id => $item) {

		?>
			<?php
			if($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) {
				$empty_categories_if	= 1;
				if(!isset($this->items[$this->parent->id][$id + 1]))
				{
					$class = ' class="last"';
				}
			?>
			<tr class="contentdescription<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
				<td >
					<div id="je-categorylisting<?php echo $tempid ?>" style="height:<?php echo $this->settings->cat_image_height; ?>px;">
						<?php
								$secid = $item->id;
								$category = JCategories::getInstance('jetestimonial')->get($secid);
								$image_cat=$category->getParams()->get('image');
						 		if ( $this->settings->show_image == '1' ) {

						?>

						 		<a href="<?php echo JRoute::_(jetestimonialHelperRoute::getCategoryRoute($item->id));?>">
						 		<img style="padding:0px 10px 0px 0px" width="<?php echo $this->settings->cat_image_width; ?>" height="<?php echo $this->settings->cat_image_height; ?>"  align="<?php echo $this->settings->image_position;?>" src="<?php echo $path; if ($image_cat!= '') : echo $category->getParams()->get('image'); else : echo "components/com_jetestimonial/assets/images/noimage/noimage.png"; endif; ?>"/>						 		 </a>
						 <?php }
						 ?>
								<span class="item-title">
									<a href="<?php echo JRoute::_(jetestimonialHelperRoute::getCategoryRoute($item->id));?>">
											<?php echo $this->escape($item->title); ?>
									</a>
								</span>


						<?php

							if ($item->description)
								{
									?>
								<div id="je-introtext"  style="text-align : justify;" >
								<?php
								}
								else
								{
										?>
									<div id="je-introtext1"  style="text-align : justify;" >
									<?php
								}
										?>	<?php if ($this->settings->show_introtext == 1){
												echo JHtml::_('content.prepare', $item->description);
											}
											 else
											 {

											 }?>
									</div>

						<?php
								if ($this->params->get('show_cat_items_cat') == 1) {
						?>
					<dl class="newsfeed-count">
						<dt>
							<?php echo JText::_('COM_JETESTIMONIAL_CAT_NUM'); ?>
						</dt>
						<dd>
							<?php echo $item->numitems; ?>
						</dd>
					</dl>
				<?php
				}
				?>

				<?php
					if(count($item->getChildren()) > 0) {
						$this->items[$item->id] = $item->getChildren();
						$this->parent = $item;
						$this->maxLevelcat--;
						echo $this->loadTemplate('items');
						$this->parent = $item->getParent();
						$this->maxLevelcat++;
				}
				?>

					<div class="clr"></div>
					</div>
				</td>
			</tr>
			<?php
			} else {
				$empty_categories_else	= 1;
			}
		}
		?>



<?php
} else {
	JError::raiseNotice(404, JText::_('COM_JETESTIMONIAL_ERROR_CATEGORIES_NOT_FOUND'));
}

if( $empty_categories_else == 1 && $empty_categories_if == 0 ) {
	if( !$this->params->get('show_empty_categories_cat') ) {
		JError::raiseNotice(404, JText::_('COM_JETESTIMONIAL_ERROR_EMPTYCATEGORIES'));
	}
}
?>
<?php
if( $n > 0 ) {
?>
</table>
</div>
<?php  

	$settings					= $this->getSettings();
	$show_pagination_jextn		= $settings->show_pagination_jextn;

	if($show_pagination_jextn){ ?>
	
<div id="jeauction-paginationarea" style="text-align : center;">
	<!-- Limit Box Drop down -->
	<!--<div class="je-limitbox">
		<label for="limit">
			<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
		</label>
		<?php echo $this->pagination->getLimitBox(); ?>
	</div>-->
	<?php
	if( $this->pagination->get('pages.total') > 1) {
	?>
		<!-- Page counter display -->
		<div class="je-pagecounter">
			<?php
				echo $this->pagination->getPagesCounter();
			?>
		</div>

		<!-- Pagination with page links -->
		<div  id="je-pagination" class="pagination">
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php
	}
    ?>
</div>
<?php
   }
 }
?>
</form>
</body>