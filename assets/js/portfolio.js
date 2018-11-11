
var IonPeBlogToolbar = wp.media.view.Toolbar.Select.extend({
	clickSelect: function() {

		var controller = this.controller,
			state = controller.state(),
			selection = state.get('selection');

		controller.close();
		state.trigger( 'insert', selection ).reset();

	}
});

var IonPeBlogFrame = wp.media.view.MediaFrame.Select.extend({

	createSelectToolbar: function( toolbar, options ) {
		options = options || this.options.button || {};
		options.controller = this;

		toolbar.view = new IonPeBlogToolbar( options );
	},

});

wp.media.frames.ionpeblog = new IonPeBlogFrame( {
    frame: 'select',
    reset: false,
    title:  wp.media.view.l10n.addToGalleryTitle,
    button: {
        text: wp.media.view.l10n.addToGallery,
    },
    multiple: 'add',
} );

wp.media.frames.ionpeblog.on( 'open', function() {

    // Get any previously selected images
    var selection = wp.media.frames.ionpeblog.state().get( 'selection' );
    selection.reset();

    //Get current images
    var images = jQuery( '#ionpeblog-portfolio-gallery-input' ).val().split( ',' );
    images = images.filter(function(n){ return n != '' });

    if ( images.length > 0 ) {
    	jQuery.each( images, function( index, id ){
    		var image = wp.media.attachment( id );
      		selection.add( image ? [ image ] : [] );
    	});

    	selection.single( selection.last() );
    	
    }

} );

wp.media.frames.ionpeblog.on( 'insert', function( selection ) {

    // Get state
    var state = wp.media.frames.ionpeblog.state();

    // Gallery Container
    var galleryContainer = jQuery('.ionpeblog-portfolio-gallery');

    // Gallery ids
    var galleryIDS = [];

    // Delete current images
    galleryContainer.html( '' );

    // Iterate through selected images, building an images array
    selection.each( function( attachment ) {
    	var attachmentAtts = attachment.toJSON(),
    		url = '';

    	galleryIDS.push( attachmentAtts['id'] );

    	if ( 'undefined' != attachmentAtts.sizes.thumbnail ) {
    		url = attachmentAtts.sizes.thumbnail.url;
    	}else{
			url = attachmentAtts.sizes.full.url;
    	}

    	galleryContainer.append( '<div class="portfolio-item"><img src="' + url + '"></div>' );

    }, this );

    jQuery( '#ionpeblog-portfolio-gallery-input' ).val( galleryIDS.join(',') );

} );

jQuery( document ).ready( function($){

	$('#add_to_portfolio-gallery').click(function(evt){
		evt.preventDefault();
		wp.media.frames.ionpeblog.open();
	});

});