/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}
(function($) {

	// overwrite default tooltip/popover behavior (same as Joomla 3.1.5) - This should be done in T3 Framework
	$.fn.tooltip.Constructor.DEFAULTS && ($.fn.tooltip.Constructor.DEFAULTS.html = true);
	$.fn.popover.Constructor.DEFAULTS && ($.fn.popover.Constructor.DEFAULTS.html = true);
	$.fn.tooltip.defaults && ($.fn.tooltip.defaults.html = true);
	$.fn.popover.defaults && ($.fn.popover.defaults.html = true);


	$(document).ready(function ($) {
		// back to top
		(function(){
			$('#back-to-top').on('click', function(){
				$('html, body').stop(true).animate({
					scrollTop: 0
				}, {
					duration: 800, 
					easing: 'easeInOutCubic',
					complete: window.reflow
				});

				return false;
			});
		})();
	});
})(jQuery);