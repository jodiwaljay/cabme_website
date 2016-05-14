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


/*Jextn Testimonial pagination*/

 if($this->settings->show_pagination_jextn){
?>
	<!-- Area for pagination -->
	<div id="jefaqpro-paginationarea" style="text-align : center;">
		<!-- Limit Box Drop down -->

			<!--<div class="je-limitbox">
				<label for="limit">
					<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>-->

			<div class="pagination">
					<p class="counter">
						<?php echo $this->pagination->getPagesCounter(); ?>
					</p>
				<?php
				echo $this->pagination->getPagesLinks();
				?>
			</div>
	</div>
<?php
}
?>