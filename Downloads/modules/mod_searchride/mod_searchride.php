<div class="search_ride">
	<div class="search_src"><input class="placepicker" type="text" name="source" placeholder="From :"/></div>
	<div class="search_ref"><a href="#"><img src="images/refrs.png" alt="search" width="48" height="46" /></a></div>
	<div class="search_dest"><input class="placepicker" type="text" name="destination" placeholder="To :" /></div>
	<div class="search_find"><a href="#">SEARCH NOW</a></div>
</div>

<script src="<?php echo JURI::root();?>modules/mod_searchride/js/jquery.placepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".placepicker").placepicker();
		jQuery("#advanced-placepicker").each(function() {
			var target = this;
			var jQuerycollapse = jQuery(this).parents('.form-group').next('.collapse');
			var jQuerymap = jQuerycollapse.find('.another-map-class');
			var placepicker = jQuery(this).placepicker({
				map: jQuerymap.get(0),
				placeChanged: function(place) {
					console.log("place changed: ", place.formatted_address, this.getLocation());
				}
			}).data('placepicker');
		});
	});
</script>





