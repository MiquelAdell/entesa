(function($){
    //cache needed for overagressive garbage collectors.
    var cache = [];
    //images can either be an array of paths to images or a  single image.
    $.loadImages = function(images, callback){

        // if our first argument is an string, we convert it to an array
        if (typeof images == "string") {
            images = [images];
        }

        var imagesLength = images.length;
        var loadedCounter = 0;

        for (var i = 0; i < imagesLength; i++) {
			var cacheImage = document.createElement('img');
			//set the onload method before the src is called otherwise will fail to be called in IE
            cacheImage.onload = function(){
                loadedCounter++;
                if (loadedCounter == imagesLength) {
                    if ($.isFunction(callback)) {
                        callback();
                    }
                }
            }
            cacheImage.src = images[i];
            cache.push(cacheImage);
        }
    }
})(jQuery)


jQuery( document ).ready(function( $ ) {
	$.fn.preload = function() {
	    this.each(function(){
	        $('<img/>')[0].src = this;
	    });
	};


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

	// use the plugin full-screen-search-overlay to open a full screen search overlay
	// this will not work if the plugin is not installed
	$('.trigger-search').click(function(event){
		if($( '#full-screen-search' ).length){
			event.preventDefault();
			$( '#full-screen-search' ).addClass( 'open' );
			$( '#full-screen-search input' ).focus();
		}
	});

	$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	    event.preventDefault();
	    $(this).ekkoLightbox();
	});

	window.sr = ScrollReveal({duration: 500,delay: 300});
	sr.reveal('.participa-belt .row');
	sr.reveal('.networks-section .col');

	if($('.home-slider').length){
		var toggleClasses = function($current,$next){
			$current.removeClass('on');
			$current.addClass('off');
			$next.removeClass('off');
			$next.addClass('on');
		};
		var loadNext = function(){
			setTimeout(function(){
				var $current = $('.home-slider li.on');
				var $next = $current.next('.off');
				if (!$next.length) {
					$next = $(".home-slider li:first");
				}
				if($next.hasClass('loaded')){
					toggleClasses($current,$next);
					loadNext();
				} else {
					console.log("next-data",$next.data('image'));
					$.loadImages([$next.data('image')], function(){
						$next.css('background-image','url("'+$next.data('image')+'")');
						$next.addClass('loaded');
						toggleClasses($current,$next);
						loadNext();
					});

				}
			},10000);
		};
		loadNext();
	}
});
