<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('JHtmlUsers', JPATH_COMPONENT . '/helpers/html/users.php');
JHtml::register('users.spacer', array('JHtmlUsers', 'spacer'));


$fieldsets = $this->form->getFieldsets();
if (isset($fieldsets['core']))   unset($fieldsets['core']);
if (isset($fieldsets['params'])) unset($fieldsets['params']);

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<script>
	function valid()
	{
    	var curpass=jQuery("input[name='jform[currentpass]']").val();
    	var newpass=jQuery("input[name='jform[password1]']").val();
		var newcnfpass=jQuery("input[name='jform[password2]']").val();

    	if(curpass=="")
    	{
	      	jQuery(".errorreport").html("Please Enter the current password");
	      	return false;
    	}
	    else
	    {
	    	jQuery(".errorreport").html("");
			jQuery.ajax({
	    		url: "<?php echo JURI::root();?>index.php?option=com_users&task=reset.passwordmatch",
	    		type: 'POST',
	    		data : {curpass:curpass},
	    		success: function (data) {
	    			if(data=="0")
	    			{
	        	      jQuery(".errorreport").html("Invalid Current Password!");
	        	      return false;
	    			}
	    		}
			});

	    }

       	if(newpass=="")
	    {
		    jQuery(".errorreport").html("Please Enter New password");
		    return false;
	    }
	    else
	    {}
        if(newcnfpass=="")
        {
       		jQuery(".errorreport").html("Please Enter Confirm Password!");
        	return false;
        }
        else if(newpass!=newcnfpass)
        {

            jQuery(".errorreport").html("Password Doesn't Match Here!");
        	return false;
        }
	    else
	    {
	    }

	    //return false;
	}
</script>


<form action="<?php echo JURI::root();?>index.php?option=com_users&task=reset.resetcheck" class="form-horizontal" method="post"  role="form">
    <span class="errorreport"></span>
	<div class="row">
       <div class="col-sm-8">
		    <div class="form-group">
		      <label class="control-label col-sm-4" for="email">Current password:</label>
		      <div class="col-sm-8">
		        <input type="password" class="form-control" name="jform[currentpass]" >
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-4" for="pwd">New password:</label>
		      <div class="col-sm-8">
		        <input type="password" id="pwd" class="form-control" name="jform[password1]" value="">
		      </div>
		    </div>
		     <div class="form-group">
		      <label class="control-label col-sm-4" for="email">Confirmed password:</label>
		      <div class="col-sm-8">
		        <input type="password" class="form-control" name="jform[password2]" value="">
		        <input type="hidden" class="form-control" name="jform[email]" value="">
		      </div>
		    </div>
			<div class="col-lg-12 text-center">
                <button type="submit" onclick="return valid();" class="btn btn-lg sub">Change Password</button>
             </div>
             <?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>






