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
			var sidebarContainer = $( '#sidebar' ),
				sidebar = $( '#secondary' ),
				$window = $( window ),
				initialTopSidebar = sidebar.offset().top,
				lastScroll = $window.scrollTop();

			sidebar.css({'max-width':sidebar.width()});

			$window.on( 'scroll', function( event ){
				var topWindow       = $window.scrollTop(),
					bottomWindow    = topWindow + $window.height(),
					topContainer    = sidebarContainer.offset().top,
					bottomContainer = topContainer + sidebarContainer.innerHeight(),
					topSidebar      = sidebar.offset().top,
					bottomSidebar   = topSidebar + sidebar.innerHeight(),
					bottom          = bottomContainer - bottomWindow,
					height          = sidebar.innerHeight();

				if ( $window.width() < 992 ) {
					sidebar.css( {
						position : 'relative',
						bottom : 'auto',
						top : 'auto' 
					} );
					return;
				}

				if ( ( bottomSidebar - topSidebar ) > ( bottomWindow - topWindow ) ) {

					if ( bottomSidebar <= bottomWindow && bottomWindow < bottomContainer ) {
						sidebar.css({
							position : 'fixed',
							bottom : '0px' 
						});
					}else if( bottomWindow >= bottomContainer ){
						sidebar.css({
							position : 'absolute',
							bottom : '0px' 
						});
					}else{
						if( topSidebar <= topContainer ) {
							sidebar.css({
								position : 'relative',
								bottom : 'auto' 
							});
						}else{
							sidebar.css({
								position : 'fixed',
								bottom : '0px' 
							});
						}
					}

				}else{

					// If we're scrolled into a section, stick the header
					if ( topWindow >= topContainer && topWindow < bottomContainer - height ) {
						sidebar.css( {
							position : 'fixed',
							top : '0px',
							bottom: 'auto',
						} );
					// If we're at the end of the section, stick the header to the bottom
					} else if ( topWindow >= bottomContainer - height && topWindow < bottomContainer ) {
						sidebar.css( {
							position: 'absolute',
							top: 'auto',
							bottom: 0,
						} );
					// Unstick the header
					} else {
						sidebar.css( {
							position : 'relative',
							bottom : 'auto',
							top : 'auto' 
						} );
					}

				}

			});
		}

	};

	$( document ).ready(function(){
		ionpeblog.init();
	});
})( jQuery )
