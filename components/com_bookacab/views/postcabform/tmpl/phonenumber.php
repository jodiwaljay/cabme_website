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

$user = JFactory::getUser();
	if(empty($user->id)){
		JFactory::getApplication()->redirect(JURI::root());
		return false;
	}

?>


<form id="book-form" action="<?php echo 'index.php?option=com_bookacab' ?>" method="post">
	<legend>Update Mobile Number</legend>
	<div class="control-label">
	<label title="" class="hasTooltip required" for="phone" id="phone-lbl" data-original-title="Enter 10 digit mobile name" aria-invalid="false">
	Mobil number<span class="star">&nbsp;*</span></label>													</div>
						<div class="controls">
							<input type="text" onkeydown="validateNumber(event);" aria-required="true" required="required" size="30" class="required" value="" id="phone" name="phone" aria-invalid="false">						</div>
					</div>
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="task" value="postcabform.updatephone" />
</form> <br/>
<a href="javascript:void(0)" value="<?php echo $user->mobile ?>" onclick="document.getElementById('book-form').submit()" class="btn pull-left">Update</a>
<script type="text/javascript">
	
function validateNumber(evt) {
    var e = evt || window.event;
    var key = e.keyCode || e.which;

    if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
    // numbers   
    key >= 48 && key <= 57 ||
    // Numeric keypad
    key >= 96 && key <= 105 ||
    // Backspace and Tab and Enter
    key == 8 || key == 9 || key == 13 ||
    // Home and End
    key == 35 || key == 36 ||
    // left and right arrows
    key == 37 || key == 39 ||
    // Del and Ins
    key == 46 || key == 45) {
        // input is VALID
    }
    else {
        // input is INVALID
        e.returnValue = false;
        if (e.preventDefault) e.preventDefault();
    }
}

</script>