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

$id = JRequest::getInt("id",0);
$token = JRequest::getVar("token","");
JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');
$db = JFactory::getDbo();
$sqlval='SELECT * from  #__bookacab where id="'.$id.'" AND token="'.$token.'"';
$db->setQuery($sqlval);
$data = $db->loadObject();
?>

<form id="book-form" action="<?php echo 'index.php?option=com_bookacab' ?>" method="post">
	<input type="hidden" name="id" value="<?php echo $id ?>"/>
	<input type="hidden" name="token" value="<?php echo $token ?>"/>
	<input type="hidden" name="task" value="" />
</form>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header pop-up share-cab">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation for Booking cab</h4>
      </div>
      <div class="modal-body">
       	<?php if(!empty($data)) : ?>
       		<div class="table-responsive">
			  <table class="table">
			  		<tr>
			   			<td>Name</td>
			   			<td><?php echo $data->name ?></td>
			   		</tr>
			   		<tr>
			   			<td>From</td>
			   			<td><?php echo $data->from ?></td>
			   		</tr>
			   		<tr>
			   			<td>To</td>
			   			<td><?php echo $data->to ?></td>
			   		</tr>
			   		<tr>
			   			<td>Seats</td>
			   			<td><?php echo $data->seats ?></td>
			   		</tr>
			  </table>
			</div>
       	<?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm-book" class="button-submit col-xs-6" data-dismiss="modal">Confirm</button>
        <button type="button" id="book-cancel" class="button-submit col-xs-6">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script>
	jQuery('#myModal').modal()

	jQuery("#confirm-book").click(function(){
		jQuery('[name="task"]').val("postcabform.confirmbook");
		jQuery("#book-form").submit();
	})

	jQuery("#book-cancel").click(function(){
		jQuery('[name="task"]').val("postcabform.cancelbook");
		jQuery("#book-form").submit();
	})
</script>