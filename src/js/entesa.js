jQuery( document ).ready(function( $ ) {
	function Utils() {

	}

	function enableScroll() {
	  $('html, body').css({
		  overflow: 'auto',
		  height: 'auto'
	  });
	}

	Utils.prototype = {
		constructor: Utils,
		isElementInView: function (element, fullyInView) {
			var pageTop = $(window).scrollTop();
			var pageBottom = pageTop + $(window).height();
			var elementTop = $(element).offset().top;
			var elementBottom = elementTop + $(element).height();

			if (fullyInView === true) {
				return ((pageTop < elementTop) && (pageBottom > elementBottom));
			} else {
				return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
			}
		}
	};

	var Utils = new Utils();
	$(window).scroll(function() {
		var isElementInView = Utils.isElementInView($('.home-slider'), false);

		if (isElementInView) {
			$('body').removeClass('navbar--fixed');
		} else {
			$('body').addClass('navbar--fixed');
		}
	});

	scrolled_after_toggle = false;
	$('.navbar-toggler').click(function(){
		if($('html').hasClass('fixed-scroll')){
			$('html').removeClass('fixed-scroll');
		} else {
			$('html').addClass('fixed-scroll');
		}

	});

	$('.grid').masonry({
		itemSelector: '.grid-item',
		width: '50%'
	});
});
