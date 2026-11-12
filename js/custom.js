'use strict';

(function ($) {

    var href = document.location.href;
	var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
	lastPathSegment=lastPathSegment.replace('#','');
	$('a[href="' + lastPathSegment + '"]').parents('li').addClass('open');

	$('form').on('focus', 'input[type=number]', function (e) {
	  $(this).on('mousewheel.disableScroll', function (e) {
		e.preventDefault()
	  })
	});
	
})(jQuery);