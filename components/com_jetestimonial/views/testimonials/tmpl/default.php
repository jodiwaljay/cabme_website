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
?>

<div id="je-faqpro">
	<?php
	if( $this->total > 0 ) {

		if ($this->params->get('show_page_heading', 1)) {
		?>
			<h1>
				<?php
				if ($this->escape($this->params->get('page_heading'))) {
					 echo $this->escape($this->params->get('page_heading'));
				} else {
					echo $this->escape($this->params->get('page_title'));
				}
				?>
			</h1>
		<?php
		} else {
			?>
				<h1> <?php echo JText::_('COM_JETESTIMONIAL_TITLE');  ?> </h1>
			<?php
		}
		?>


		<form id="searchForm" action="<?php echo JRoute::_('index.php');?>" method="post">

			<?php
				echo $this->loadTemplate('testimonials');
				echo $this->loadTemplate('testimonialspagination');
			?>

			<input type="hidden" name="task" value="testimonials" />
			<input type="hidden" name="option" value="com_jetestimonial" />
			<input type="hidden" name="limitstart" value="" />
		</form>
	<?php
	}
	?>
</div>

<?php
if($this->params->get('show_footertext', 1)) {
?>
	<p class="copyright" style="text-align : right; font-size : 10px;">
		<?php require_once( JPATH_COMPONENT . DS . 'copyright' . DS . 'copyright.php' ); ?>
	</p>
<?php
}
?>
