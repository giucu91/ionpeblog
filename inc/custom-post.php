<?php

// Register Custom Post Type
function ionpeblog_portfolio() {

	$labels = array(
		'name'                  => _x( 'Portofoliu', 'Post Type General Name', 'ionpeblog' ),
		'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'ionpeblog' ),
		'menu_name'             => __( 'Portfolios', 'ionpeblog' ),
		'name_admin_bar'        => __( 'Portfolio', 'ionpeblog' ),
		'archives'              => __( 'Item Archives', 'ionpeblog' ),
		'attributes'            => __( 'Item Attributes', 'ionpeblog' ),
		'parent_item_colon'     => __( 'Parent Item:', 'ionpeblog' ),
		'all_items'             => __( 'All Items', 'ionpeblog' ),
		'add_new_item'          => __( 'Add New Item', 'ionpeblog' ),
		'add_new'               => __( 'Add New', 'ionpeblog' ),
		'new_item'              => __( 'New Item', 'ionpeblog' ),
		'edit_item'             => __( 'Edit Item', 'ionpeblog' ),
		'update_item'           => __( 'Update Item', 'ionpeblog' ),
		'view_item'             => __( 'View Item', 'ionpeblog' ),
		'view_items'            => __( 'View Items', 'ionpeblog' ),
		'search_items'          => __( 'Search Item', 'ionpeblog' ),
		'not_found'             => __( 'Not found', 'ionpeblog' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ionpeblog' ),
		'featured_image'        => __( 'Featured Image', 'ionpeblog' ),
		'set_featured_image'    => __( 'Set featured image', 'ionpeblog' ),
		'remove_featured_image' => __( 'Remove featured image', 'ionpeblog' ),
		'use_featured_image'    => __( 'Use as featured image', 'ionpeblog' ),
		'insert_into_item'      => __( 'Insert into item', 'ionpeblog' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'ionpeblog' ),
		'items_list'            => __( 'Items list', 'ionpeblog' ),
		'items_list_navigation' => __( 'Items list navigation', 'ionpeblog' ),
		'filter_items_list'     => __( 'Filter items list', 'ionpeblog' ),
	);
	$args = array(
		'label'                 => __( 'Portfolio', 'ionpeblog' ),
		'description'           => __( 'Post Type Description', 'ionpeblog' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'portfoliu', $args );

}
add_action( 'init', 'ionpeblog_portfolio', 0 );

// Register Custom Taxonomy
function ionpeblog_portfolio_clients() {

	$labels = array(
		'name'                       => _x( 'Clients', 'Taxonomy General Name', 'ionpeblog' ),
		'singular_name'              => _x( 'Client', 'Taxonomy Singular Name', 'ionpeblog' ),
		'menu_name'                  => __( 'Clients', 'ionpeblog' ),
		'all_items'                  => __( 'All Items', 'ionpeblog' ),
		'parent_item'                => __( 'Parent Item', 'ionpeblog' ),
		'parent_item_colon'          => __( 'Parent Item:', 'ionpeblog' ),
		'new_item_name'              => __( 'New Item Name', 'ionpeblog' ),
		'add_new_item'               => __( 'Add New Item', 'ionpeblog' ),
		'edit_item'                  => __( 'Edit Item', 'ionpeblog' ),
		'update_item'                => __( 'Update Item', 'ionpeblog' ),
		'view_item'                  => __( 'View Item', 'ionpeblog' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'ionpeblog' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'ionpeblog' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'ionpeblog' ),
		'popular_items'              => __( 'Popular Items', 'ionpeblog' ),
		'search_items'               => __( 'Search Items', 'ionpeblog' ),
		'not_found'                  => __( 'Not Found', 'ionpeblog' ),
		'no_terms'                   => __( 'No items', 'ionpeblog' ),
		'items_list'                 => __( 'Items list', 'ionpeblog' ),
		'items_list_navigation'      => __( 'Items list navigation', 'ionpeblog' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'portfolio_clients', array( 'portfoliu' ), $args );

}
add_action( 'init', 'ionpeblog_portfolio_clients', 0 );

// Register Custom Taxonomy
function ionpeblog_portfolio_categories() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'ionpeblog' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'ionpeblog' ),
		'menu_name'                  => __( 'Categories', 'ionpeblog' ),
		'all_items'                  => __( 'All Items', 'ionpeblog' ),
		'parent_item'                => __( 'Parent Item', 'ionpeblog' ),
		'parent_item_colon'          => __( 'Parent Item:', 'ionpeblog' ),
		'new_item_name'              => __( 'New Item Name', 'ionpeblog' ),
		'add_new_item'               => __( 'Add New Item', 'ionpeblog' ),
		'edit_item'                  => __( 'Edit Item', 'ionpeblog' ),
		'update_item'                => __( 'Update Item', 'ionpeblog' ),
		'view_item'                  => __( 'View Item', 'ionpeblog' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'ionpeblog' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'ionpeblog' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'ionpeblog' ),
		'popular_items'              => __( 'Popular Items', 'ionpeblog' ),
		'search_items'               => __( 'Search Items', 'ionpeblog' ),
		'not_found'                  => __( 'Not Found', 'ionpeblog' ),
		'no_terms'                   => __( 'No items', 'ionpeblog' ),
		'items_list'                 => __( 'Items list', 'ionpeblog' ),
		'items_list_navigation'      => __( 'Items list navigation', 'ionpeblog' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'portfolio_categories', array( 'portfoliu' ), $args );

}
add_action( 'init', 'ionpeblog_portfolio_categories', 0 );

// Register Custom Taxonomy
function ionpeblog_portfolio_skills() {

	$labels = array(
		'name'                       => _x( 'Skills', 'Taxonomy General Name', 'ionpeblog' ),
		'singular_name'              => _x( 'Skill', 'Taxonomy Singular Name', 'ionpeblog' ),
		'menu_name'                  => __( 'Skills', 'ionpeblog' ),
		'all_items'                  => __( 'All Items', 'ionpeblog' ),
		'parent_item'                => __( 'Parent Item', 'ionpeblog' ),
		'parent_item_colon'          => __( 'Parent Item:', 'ionpeblog' ),
		'new_item_name'              => __( 'New Item Name', 'ionpeblog' ),
		'add_new_item'               => __( 'Add New Item', 'ionpeblog' ),
		'edit_item'                  => __( 'Edit Item', 'ionpeblog' ),
		'update_item'                => __( 'Update Item', 'ionpeblog' ),
		'view_item'                  => __( 'View Item', 'ionpeblog' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'ionpeblog' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'ionpeblog' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'ionpeblog' ),
		'popular_items'              => __( 'Popular Items', 'ionpeblog' ),
		'search_items'               => __( 'Search Items', 'ionpeblog' ),
		'not_found'                  => __( 'Not Found', 'ionpeblog' ),
		'no_terms'                   => __( 'No items', 'ionpeblog' ),
		'items_list'                 => __( 'Items list', 'ionpeblog' ),
		'items_list_navigation'      => __( 'Items list navigation', 'ionpeblog' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
	);
	register_taxonomy( 'portfolio_skills', array( 'portfoliu' ), $args );

}
add_action( 'init', 'ionpeblog_portfolio_skills', 0 );

// Create Metabox for Gallery
add_action( 'load-post.php', 'ionpeblog_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'ionpeblog_post_meta_boxes_setup' );

/* Meta box setup function. */
function ionpeblog_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'ionpeblog_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'ionpeblog_save_portfolio_gallery_meta', 10, 2 );

}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function ionpeblog_add_post_meta_boxes() {

  add_meta_box( 'ionpeblog-portfolio-gallery', esc_html__( 'Portfolio Gallery', 'ionpeblog' ), 'ionpeblog_portfolio_gallery_meta_box', 'portfoliu', 'side', 'default' );
}

/* Display the post meta box. */
function ionpeblog_portfolio_gallery_meta_box( $post ) {

  	wp_nonce_field( basename( __FILE__ ), 'ionpeblog_portfolio_gallery_nonce' );

  	$images_ids = get_post_meta( $post->ID, 'ionpeblog-portfolio-gallery', true );
  	$images = explode( ',', $images_ids );

?>
	<input id="ionpeblog-portfolio-gallery-input" type="hidden" name="ionpeblog-portfolio-gallery" value="<?php echo $images_ids ?>">
	<style type="text/css">
		.ionpeblog-portfolio-gallery {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			margin-bottom: 10px;
		}
		.ionpeblog-portfolio-gallery > div {
			width: 30%;
			margin-right: 4.5%;
		}
		.ionpeblog-portfolio-gallery > div:nth-child( 3n ) {
			margin-right: 0;
		}
		.ionpeblog-portfolio-gallery > div img {
			max-width: 100%;
		    height: auto;
		    width: auto;
		    vertical-align: top;
		    background-image: linear-gradient(45deg,#c4c4c4 25%,transparent 25%,transparent 75%,#c4c4c4 75%,#c4c4c4),linear-gradient(45deg,#c4c4c4 25%,transparent 25%,transparent 75%,#c4c4c4 75%,#c4c4c4);
		    background-position: 0 0,10px 10px;
		    background-size: 20px 20px;
		}
	</style>
	<div class="ionpeblog-portfolio-gallery">
		<?php

		if ( count( $images ) > 0 ) {
			foreach ( $images as $image ) {
				$url = wp_get_attachment_image_src( $image );
				if ( $url ) {
					echo '<div><img src="' . $url[0] . '"></div>';
				}
			}
		}

		?>
	</div>
	<a href="#" id="add_to_portfolio-gallery">Add/remove gallery images</a>

<?php }


/* Save the meta box's post metadata. */
function ionpeblog_save_portfolio_gallery_meta( $post_id, $post ) {

  	/* Verify the nonce before proceeding. */
  	if ( ! isset( $_POST['ionpeblog_portfolio_gallery_nonce'] ) || ! wp_verify_nonce( $_POST['ionpeblog_portfolio_gallery_nonce'], basename( __FILE__ ) ) ){
    	return $post_id;
  	}

  	/* Get the post type object. */
  	$post_type = get_post_type_object( $post->post_type );

  	/* Check if the current user has permission to edit the post. */
  	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
    	return $post_id;
	}

  	/* Get the posted data and sanitize it for use as an HTML class. */
  	$new_meta_value = ( isset( $_POST['ionpeblog-portfolio-gallery'] ) ? esc_html( $_POST['ionpeblog-portfolio-gallery'] ) : '' );

  	/* Get the meta key. */
  	$meta_key = 'ionpeblog-portfolio-gallery';

  	/* Get the meta value of the custom field key. */
  	$meta_value = get_post_meta( $post_id, $meta_key, true );

  	/* If a new meta value was added and there was no previous value, add it. */
  	if ( $new_meta_value && '' == $meta_value ){
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
    }

  	/* If the new meta value does not match the old value, update it. */
  	elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
  		update_post_meta( $post_id, $meta_key, $new_meta_value );
  	}

  	/* If there is no new meta value but an old value exists, delete it. */
  	elseif ( '' == $new_meta_value && $meta_value ) {
    	delete_post_meta( $post_id, $meta_key, $meta_value );
	}
}

// 
add_action( 'admin_enqueue_scripts', 'ionpeblog_admin_scripts' );

function ionpeblog_admin_scripts( $hook ) {

	global $id, $post;

	// Get current screen.
    $screen = get_current_screen();

    // Check if is modula custom post type
    if ( 'portfoliu' !== $screen->post_type ) {
        return;
    }

    // Set the post_id
    $post_id = isset( $post->ID ) ? $post->ID : (int) $id;

    if ( 'post-new.php' == $hook || 'post.php' == $hook ) {
    	// Media Scripts
		wp_enqueue_media( array(
            'post' => $post_id,
        ) );

		wp_enqueue_script( 'ionpeblog-portfolio', get_stylesheet_directory_uri() . '/assets/js/portfolio.js', array( 'jquery' ), '1.0.0', true );

    }

}