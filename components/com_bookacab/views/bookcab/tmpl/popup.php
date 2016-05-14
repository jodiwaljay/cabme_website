<?php
/*
 * Created on Mar 31, 2016
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  $itemid= $_REQUEST['id'];
  $db = JFactory::getDbo();
  $sqldr='SELECT * from  #__postacab where id='.$itemid;
  $db->setQuery($sqldr);
  $results=$db->loadObject();

?>

<div class="modal-header pop-up share-cab">
	<center><h4 class="modal-title modal-title-color">How many seats you are looking for?</h4></center>
</div>
<div class="postSeats">
   <form method="post">
		<div class="popup_seat">
	        <select id="seats" name="popseats">
	          <option value="">Select your required seats</option>
	          <?php

	             for($i=1;$i<=$results->no_of_seats;$i++)
	             {?>
	                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	             <?php }

	          ?>
	        </select>
        </div>
        <div class="popup_submit">
        	<button type="button" value="Submit">Submit</button>
			<input type="hidden" name="drname" value="<?php echo $results->name; ?>" />
			<input type="hidden" name="drmobile" value="<?php echo $results->mobile; ?>" />
			<input type="hidden" name="drfrom" value="<?php echo $results->from; ?>" />
			<input type="hidden" name="drto" value="<?php echo $results->to; ?>" />
			<input type="hidden" name="drcbtype" value="<?php echo $results->cab_type; ?>" />
			<?php
				$user =JFactory::getUser();
				$userId = $user->get( 'id' );
				$userName = $user->get( 'name' );
				$userMobile = $user->get( 'mobile' );
			?>
			<input type="hidden" name="uname" value="<?php echo $userName;  ?>" />
			<input type="hidden" name="umobile" value="<?php echo $userMobile;  ?>" />
        </div>
   </form>
</div>



<script type="text/javascript">
	<!--join now sms function -->
	jQuery(document).ready(function(){
		var itemId="<?php echo $itemid; ?>";
		jQuery("form button[type='button']").click(function(){
			butoon = jQuery(this);
			butoon.val("Loding...");
			butoon.text("Loding...");
			butoon.attr("disabled",true);
            var seats=jQuery("select").val();
            var drname=jQuery("input[name='drname']").val();
            var drmobile=jQuery("input[name='drmobile']").val();
            var drfrom=jQuery("input[name='drfrom']").val();
            var drto=jQuery("input[name='drto']").val();
            var drcbtype=jQuery("input[name='drcbtype']").val();
            var uname=jQuery("input[name='uname']").val();
            var umobile=jQuery("input[name='umobile']").val();
            jQuery.ajax
			({
		    	type: "POST",
				url: "<?php echo JURI::root();?>index.php?option=com_bookacab&task=postcabform.getjoinnow",
				   data: {itemId:itemId,seats:seats,drname:drname,drmobile:drmobile,drfrom:drfrom,drto:drto,drcbtype:drcbtype,uname:uname,umobile:umobile},
				   success: function(data)
				   {
				   	butoon.remove();
					 //alert(data);
					 if(data=='1')
				   	{
					    alert("Thankyou for booking a Cab. Soon will receive a confirmation message");
				   	    window.location="index.php?option=com_sppagebuilder&view=page&id=1";
				   	}
				   }
			});
		});
	});
</script>
