<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Driver_details
 * @author     Tabrez ulla khan <tabrez@redwebdesign.in>
 * @copyright  Copyright (C) 2016. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_driver_details', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_driver_details/js/form.js');

$model= $this->getModel('driverdetailform');
$cabtypes= $model->getcabs();


/**/
?>

<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-driverdetail').submit(function (event) {

			});
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-driverdetail').submit(function (event) {

			});
		});
	}
	/*function getcab()
	{
		jQuery.ajax
         ({
           type: "POST",
           url: "<?php echo JURI::root();?>index.php?option=com_driver_details&task=driverdetailform.getcabs",
           data: {},
           success: function(data)
           {
           	  jQuery(".cabtypeInner").html(data);
           }
         });

	}
	getcab();*/
</script>

<div class="driverdetail-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<!--<h1>Add</h1>-->
	<?php endif; ?>

	<form id="form-driverdetail"
		  action="<?php echo JRoute::_('index.php?option=com_driver_details&task=driverdetail.save'); ?>"
		  method="post" class="form-horizontal" enctype="multipart/form-data">
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<div class="row  text-center sppb-text-center">
		<h3 class="drivehdng">Become a Driver</h3>
	</div>
	<div class="row bcomdriver">

		<div class="col-md-6">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('dname'); ?></div>
				<div class="colonlabels">:</div>
				<div class="controls"><?php echo $this->form->getInput('dname'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('demail'); ?></div>
				<div class="colonlabels">:</div>
				<div class="controls"><?php echo $this->form->getInput('demail'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('dmobile'); ?></div>
				<div class="colonlabels">:</div>
				<div class="controls"><?php echo $this->form->getInput('dmobile'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('dgen'); ?></div>
				<div class="colonlabels">:</div>
				<div class="controls"><?php echo $this->form->getInput('dgen'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('daddr'); ?></div>
				<div class="colonlabels">:</div>
				<div class="controls"><?php echo $this->form->getInput('daddr'); ?></div>
			</div>

			<div class="text-center smoking">
				<label class="radio-inline">
	 				 <input class="nosmoke" type="radio" name="optradio">No Smoking
				</label>
			    <label class="radio-inline">
			    	<input class="nosmoke" type="radio" name="optradio">Smoking
			    </label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="cab_group">
				<div  class="Addmore_cabs"><button id="addcab" type="button">Add More</button></div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('cab_no[]'); ?></div>
					<div class="colonlabels">:</div>
					<div class="controls"><?php echo $this->form->getInput('cab_no[]'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><label for="cabtype">Cab Type</label></div>
					<div class="colonlabels">:</div>
					<div class="controls">

                         <select class="driver_cabtype" name="jform[cab_type]" id="cab_type"><option value="0">Choose Cab Type</option>
						 <?php
						  foreach($cabtypes as $res)
						  {
						   ?>
						    <option value="<?php echo $res->cab_type;  ?>"><?php echo $res->cab_type;  ?></option>
						   <?php
						  }
						?>
                         </select>

					</div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('price_per_km[]'); ?></div>
					<div class="colonlabels">:</div>
					<div class="controls"><?php echo $this->form->getInput('price_per_km[]'); ?></div>
				</div>
			</div>
			<div class="addmorecabs"></div>

			<div class="control-group route_prefer">
				<div class="control-label"><?php echo $this->form->getLabel('route_prefer'); ?></div>
				<div class="colonlabels">:</div>
				<div class="controls"><?php echo $this->form->getInput('route_prefer'); ?></div>
			</div>
		</div>
		<div class="col-md-12 text-center termsagree">
	  			<label class="checkbox-inline" for="agreeterms">
      				<input name="agreeterms" type="checkbox" id="agreeterms" value=""/>I accept all <span class="trmsagr"><a href="index.php?option=com_sppagebuilder&view=page&id=13" target="_blank">terms and conditions</a></span>
      			</label>
		</div>
	</div>

				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','driver_details')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','driver_details')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-driverdetail").appendChild(input);
                    });
                </script>
             <?php endif; ?>


		<div class="control-group text-center">
			<div class="controls drivesubmit">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary bcmdrisub">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<!-- <a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_driver_details&task=driverdetailform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a> -->
			</div>
		</div>
		<input type="hidden" name="option" value="com_driver_details"/>
		<input type="hidden" name="task"
			   value="driverdetailform.save"/>
		<?php echo JHtml::_('form.token'); ?>

	</form>
</div>

<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
	jQuery(document).ready(function(){
	  	/*
	  	jQuery.validator.addMethod("phoneno", function(phone_number, element) {
	    	phone_number = phone_number.replace(/\s+/g, "");
	    	return this.optional(element) || phone_number.length > 9 &&
	    	phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    	}, "Please specify a valid mobile number");

		jQuery("#form-driverdetail").validate({
		rules: {
			 'jform[name]': "required",
			 'jform[email1]':{
	              required: true,
	              email: true,
	          },
             'jform[dmobile]':{
                     required:true,
			         phoneno:true,
			         minlength:9,
			         maxlength:10,
             },
             'jform[password1]': "required",
             'jform[dgen]':{
             	required: true,
             },
             'jform[daddr]': "required",
             optradio: "required",
             'jform[cab_no]': "required",
             'jform[cab_type]': "required",
             'jform[price_per_km]': "required",
             'jform[license_no]': "required",
             'jform[route_prefer]': "required",
             agreeterms: {
             	required: true,
             }
		},
		messages: {
		  'jform[name]': "Enter your name",
		  'jform[email1]': "Enter your email id",
		  'jform[dmobile]': "Enter your mobile number",
		  'jform[password1]': "Enter your password",
		  'jform[dgen]':"Select your gender",
		  'jform[daddr]': "Enter your address",
		  optradio: "Required field",
		  'jform[cab_no]': "Enter your cab number ",
		  'jform[cab_type]': "Enter your cab type ",
		  'jform[price_per_km]': "Enter your price/km ",
		  'jform[license_no]':  "Enter your license number",
		  'jform[route_prefer]': "Enter your preffered route",
		  agreeterms: "Please agree terms and conditions"
		},
			submitHandler: function(form) {
				form.submit();
			}
		});
	*/
		<!-- Add more Cab Details  -->
		var counter = 1;
	    jQuery("#addcab").live("click",function(){

	       var newCab = jQuery("<div class='cab_group'>");
	        var rows = "";
			rows += '<div class="removebtn Addmore_cabs"><button type="button" class="ibtnDel"  value="Delete">Delete</button></div>';
			rows += '<div class="control-group"><div class="control-label"><label id="jform_cab_no-lbl" class="" for="jform_cab_no" aria-invalid="false"> Cab No</label></div><div class="colonlabels">:</div><div class="controls"><input id="jform_cab_no' + counter + '" class="inputbox" type="text" size="40" value="" name="jform[cab_no]"></div></div>';
			rows += '<div class="control-group"><div class="control-label"><label id="jform_cab_type-lbl" class="" for="jform_cab_type" aria-invalid="false"> Cab Type</label></div><div class="colonlabels">:</div><div class="controls"><div class="cabtypeInner"><select class="driver_cabtype" name="jform[cab_type][]" id="cab_type"><option value="0">Choose Cab Type</option><?php foreach($cabtypes as $res){?><option value="<?php echo $res->cab_type;  ?>"><?php echo $res->cab_type;  ?></option><?php } ?></select></div></div></div>';
			rows += '<div class="control-group"><div class="control-label"><label id="jform_price_per_km-lbl" class="" for="jform_price_per_km" aria-invalid="false"> Price Per Km</label></div><div class="colonlabels">:</div><div class="controls"><input id="jform_price_per_km' + counter + '" class="inputbox" type="text" size="40" value="" name="jform[price_per_km]"></div></div>';

	        newCab.append(rows);
	        if (counter == 1000) jQuery('#addcab').attr('disabled', true).prop('value', "Done");
	        jQuery(".addmorecabs").append(newCab);
	        counter++;

		});
		<!-- Add more Cab Details ends -->

		<!-- Remove cab -->
	    jQuery(".ibtnDel").live("click",function(){
	      jQuery(this).closest(".cab_group").remove();
	        counter -= 1;
	    });
    	<!-- Remove cab ends -->

		jQuery.Ajax({

		})


	});
</script>
