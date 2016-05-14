<?php
/*
 * Created on Mar 31, 2016
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
   $bdate= $_REQUEST['date'];
   $btime= $_REQUEST['time'];
   $bbookfrom= $_REQUEST['bookfrom'];
   $bbookto= $_REQUEST['bookto'];
   $bcartype= $_REQUEST['cartype'];

   $bname= $_REQUEST['bname'];
   $bemail= $_REQUEST['bemail'];
   $bmobile= $_REQUEST['bmobile'];
?>

<div class="modal-header pop-up share-cab">
	<center><h4 class="modal-title modal-title-color">Do You Want to Share a Cab</h4></center>
</div>

<div class="pop-up-area">
	<form id="form-report" action="<?php echo JRoute::_('index.php?option=com_bookacab&task=bookcabform.save'); ?>" method="post" name="postForm" class="form-validate form-horizontal" >

		<div class="radio" id="choice">
			<p><input id="choice1"  type="radio" name="optradio" value="Yes" />Yes</p>
			<p><input id="choice2"  type="radio"  name="optradio" value="No" />No</p>
		</div>

		<!--<input type="hidden" id="date" name="jform[date]" value="<?php echo $bdate; ?>"  >
		<input type="hidden" id="time" name="jform[time]" value="<?php echo $btime; ?>" >
		<input type="hidden" id="bookfrom" name="jform[from]" value="<?php echo $bbookfrom; ?>" >
		<input type="hidden" id="bookto" name="jform[to]" value="<?php echo $bbookto; ?>" >
		<input type="hidden" id="cartype" name="jform[cab_type]" value="<?php echo $bcartype; ?>" >


		<input id="bname" type="hidden" name="jform[name]"  value="<?php echo $bname; ?>">
		<input id="bemail" type="hidden" name="jform[email]"  value="<?php echo $bemail; ?>">
		<input id="bmobile" type="hidden" name="jform[mobile]"  value="<?php echo $bmobile; ?>">-->

		<!--<div class="control-group center-text share_cab_btn">
			<input id="report-submit" onsubmit="return submitForm();" type="submit" class="validate btn btn-primary post-btn" value="Submit">
		</div>-->
		<?php echo JHtml::_('form.token'); ?>

	</form>
</div>


<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#choice input[name='optradio']").click(function(){
			var pick=jQuery(this).val();
			if(pick=="Yes")
			{
            	window.location="index.php?option=com_sppagebuilder&view=page&id=1&slide=2";
			}
			else
			{
               jQuery('form#form-report').submit();
			}
			//jQuery("#choice1").prop("checked", true);
		});
	});
</script>
