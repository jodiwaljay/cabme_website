/**
 * JE Testimonial package
 * @author J-Extension <contact@jextn.com>
 * @link http://www.jextn.com
 * @copyright (C) 2010 - 2011 J-Extension
 * @license GNU/GPL, see LICENSE.php for full license.
**/

Joomla.submitbutton = function(task)
{
	if (task == '') {
		return false;
	} else {
		var isValid		= true;
		var action 		= task.split('.');
		if (action[1] != 'cancel' && action[1] != 'close') {
			var forms = $$('form.form-validate');
			for (var i=0;i<forms.length;i++)
			{
				if (!document.formvalidator.isValid(forms[i]))
				{
					isValid = false;
					break;
				}
			}

			var theurl		= document.getElementById('jform_website');
			var thelabel	= document.getElementById('jform_website-lbl');

			var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/

			if( theurl.value != '' ) {
			     if (tomatch.test(theurl.value)) {
			        isValid = true;
			     } else {
			     	theurl.className	= theurl.className+' '+'invalid';
			     	thelabel.className	= thelabel.className+' '+'invalid';
			        isValid = false;
			     }
			}
		}

		if (isValid) {
			Joomla.submitform(task);
			return true;
		} else {
			return false;
		}
	}
}

