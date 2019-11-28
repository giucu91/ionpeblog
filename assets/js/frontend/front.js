(function( $ ){

	"use strict";

	var ionpeblog = {
		portfolioCarousel: null,
		homeCarousel: null,


		init: function(){
			var ionpeblog = this;

			ionpeblog.portfolioCarousel = $('.entry-gallery');
			ionpeblog.homeCarousel      = $('#main-slider');

			if ( ionpeblog.portfolioCarousel.length > 0 ) {
				ionpeblog.initPortfolioCarousel();
			}

			if ( ionpeblog.homeCarousel.length > 0 ) {
				ionpeblog.initHomeCarousel();
			}

			ionpeblog.initSocials();
			ionpeblog.initSmartSidebar();
			ionpeblog.initLazyLoad();

			$( '.mobile-menu' ).click(function(){
				$( 'body' ).toggleClass( 'ionpeblog-open-mobile-menu' );
			});

			$( '.navigation-overlay' ).click(function(){
				$( 'body' ).removeClass( 'ionpeblog-open-mobile-menu' );
			});

		},

		initPortfolioCarousel: function(){
			var ionpeblog = this;

			ionpeblog.portfolioCarousel.owlCarousel({
				items: 1,
				loop: true,
				nav: true,
				dots: false,
				navText: [ $( '.ionpeblog-navigation #ionpeblog-navigation-prev' ), $( '.ionpeblog-navigation #ionpeblog-navigation-next' ) ],
				navElement: 'div',
			});

		},

		initHomeCarousel: function(){
			var ionpeblog = this;

			ionpeblog.homeCarousel.owlCarousel({
				items: 1,
				loop: true,
				dots: false,
				autoplay: true,
				autoplaySpeed: 1000,
				lazyLoad: true,
			});

		},

		initSocials: function(){

			$('.ionpeblog-social-share a').on('click', function (e) {
				e.preventDefault();

				var newwindow = window.open($(this).attr('href'), '', 'height=500,width=500');
				if ( window.focus ) {
					newwindow.focus()
				}

				return false;
			});

		},

		initSmartSidebar: function() {
			// var sticky = new Sticky('#secondary');
			$("#secondary").stick_in_parent();
		},

		initLazyLoad: function() {
			var myLazyLoad = new LazyLoad({
			    elements_selector: ".ionpeblog-lazy"
			});
		}

	};

	$( document ).ready(function(){
		ionpeblog.init();
	});
})( jQuery )
