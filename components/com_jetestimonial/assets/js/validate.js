/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

Joomla.submitbutton = function(task) {
	if (task == 'testimonial.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {

	var isValid		= true;
		var theurl		= document.getElementById('jform_website');
		var thelabel	= document.getElementById('jform_website-lbl');

		if( theurl != null ) {
			var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;

			if( theurl.value != '' ) {
			     if (tomatch.test(theurl.value)) {
			        isValid		= true;
			     } else {
			     	theurl.className	= theurl.className+' '+'invalid';
			     	thelabel.className	= thelabel.className+' '+'invalid';

			      	isValid		= false;
			     }
			}
		}

		if (isValid) {
			Joomla.submitform(task);
			return true;
		} else {
			return false;
		}
	} else {
		var dl					= document.getElementById('system-message');
		dl.style.display 		= 'block';
		var div					= document.getElementById('je-error-message');
		var jeerror				= document.getElementById('je-errorwarning-message').value;
		div.innerHTML			= jeerror;
	}
}