
    jQuery(document).ready(function() {
 		jQuery('.ratings_stars').hover(
            // Handles the mouseover
            function() {

                jQuery(this).prevAll().andSelf().addClass('ratings_over');


            },

            // Handles the mouseout

            function() {

                jQuery(this).prevAll().andSelf().removeClass('ratings_over');

            }

        );

		//send ajax request to rate.php
        jQuery('.ratings_stars').bind('click', function() {
			var id=jQuery(this).parent().attr("id");
			//alert(id);
		    var num=jQuery(this).attr("class");
			var poststr="id="+id+"&stars="+num;
				jQuery.ajax({url:"index.php?option=com_bookacab&task=bookcabform.rate",cache:0,data:poststr,success:function(result){
                       //alert(result);
			        document.getElementById(id).innerHTML=result;

			      jQuery( ".total_votes" ).delay( 1000 ).fadeOut( 400 );

				}
			   });
		});
    });


