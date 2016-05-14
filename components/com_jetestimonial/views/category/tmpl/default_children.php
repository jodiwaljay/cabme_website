<?php
/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';
if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) {
?>
	<ul>
		<?php
		foreach($this->children[$this->category->id] as $id => $child) {
			if($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) {
				if(!isset($this->children[$this->category->id][$id + 1]))
				{
					$class = ' class="last"';
				}
			?>
				<li<?php echo $class; ?>>
					<?php $class = ''; ?>
						<span class="item-title">
							<a href="<?php echo JRoute::_(jetestimonialHelperRoute::getCategoryRoute($child->id));?>">
								<?php echo $this->escape($child->title); ?>
							</a>
						</span>

						<?php
						if ($this->params->get('show_subcat_desc') == 1) {
							if ($child->description) {
							?>
								<div class="category-desc">
									<?php echo JHtml::_('content.prepare', $child->description); ?>
								</div>
							<?php
							}
						}

			            if ($this->params->get('show_cat_items') == 1) {
			            ?>
							<dl class="newsfeed-count">
								<dt>
									<?php echo JText::_('COM_JETESTIMONIAL_CAT_NUM'); ?>
								</dt>
								<dd>
									<?php echo $child->numitems; ?>
								</dd>
							</dl>
						<?php
			            }

						if(count($child->getChildren()) > 0) {
							$this->children[$child->id] = $child->getChildren();
							$this->category = $child;
							$this->maxLevel--;
							echo $this->loadTemplate('children');
							$this->category = $child->getParent();
							$this->maxLevel++;
						}
						?>
				</li>
			<?php
			}
		}
		?>
	</ul>
<?php
}
?>