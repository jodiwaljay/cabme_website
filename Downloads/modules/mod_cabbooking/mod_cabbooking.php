<div class="cab_book">
	<form id="form-bookcab"
		action="<?php echo JRoute::_('index.php?option=com_bookacab&task=bookcab.save'); ?>"
		method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		<label>Date: </label><input type="text" name="jform[date]"><br>
		<label>Time: </label><input type="text" name="jform[time]"><br>
		<label>From: </label><input type="text" name="jform[from]" ><br>
		<label>To: </label><input type="text" name="jform[to]" ><br>
		<label>Cab Type: </label>
		<select>
			<option>Choose Cab Type</option>
			<option value="1">Small Cab [ ac ]</option>
			<option value="2">Small Cab [ non - ac ]</option>
			<option value="3">Tavera [ ac ]</option>
			<option value="4">Tavera [ non - ac ]</option>
			<option value="3">Innova [ ac ]</option>
			<option value="4">Innova [ non - ac ] </option>
		</select><br>
		<input type="submit" value="Book Now">
		<input type="hidden" name="option" value="com_bookacab"/>
		<input type="hidden" name="task"
			   value="bookcabform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>







