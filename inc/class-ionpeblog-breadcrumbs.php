<?php

class Ionpeblog_Breadcrumbs {

	/**
	 * @var mixed Current post object
	 */
	private $post;

	/**
	 * @var    array Theme Options array, with all needed data
	 */
	private $options;

	/**
	 * @var    string Prefix for the breadcrumb path
	 */
	private $home_prefix;

	/**
	 * @var    string Separator between single breadscrumbs
	 */
	private $separator;

	/**
	 * @var    boolean True if terms should be shown in breadcrumb path
	 */
	private $show_terms;

	/**
	 * @var    string Label for the "Home" link
	 */
	private $home_label;

	/**
	 * @var    string Prefix used for pages like date archive
	 */
	private $tag_archive_prefix;

	/**
	 * @var    string Prefix used for search page
	 */
	private $search_prefix;

	/**
	 * @var    string Prefix used for 404 page
	 */
	private $error_prefix;

	/**
	 * @var string The HTML markup
	 */
	private $html_markup;

	private $home_icon = '<svg aria-hidden="true" data-prefix="fas" data-icon="home" class="svg-inline--fa fa-home fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#404040" d="M488 312.7V456c0 13.3-10.7 24-24 24H348c-6.6 0-12-5.4-12-12V356c0-6.6-5.4-12-12-12h-72c-6.6 0-12 5.4-12 12v112c0 6.6-5.4 12-12 12H112c-13.3 0-24-10.7-24-24V312.7c0-3.6 1.6-7 4.4-9.3l188-154.8c4.4-3.6 10.8-3.6 15.3 0l188 154.8c2.7 2.3 4.3 5.7 4.3 9.3zm83.6-60.9L488 182.9V44.4c0-6.6-5.4-12-12-12h-56c-6.6 0-12 5.4-12 12V117l-89.5-73.7c-17.7-14.6-43.3-14.6-61 0L4.4 251.8c-5.1 4.2-5.8 11.8-1.6 16.9l25.5 31c4.2 5.1 11.8 5.8 16.9 1.6l235.2-193.7c4.4-3.6 10.8-3.6 15.3 0l235.2 193.7c5.1 4.2 12.7 3.5 16.9-1.6l25.5-31c4.2-5.2 3.4-12.7-1.7-16.9z"></path></svg>';


	/**
	 * Class Constructor
	 */
	public function __construct() {

		// Initialize object variables
		$this->post = ( isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null );

		// Setup default array for changeable variables
		$defaults = array(
			'home_prefix'            => false,
			'separator'              => '/',
			'show_post_type_archive' => true,
			'show_terms'             => false,
			'home_label'             => __( 'Acasă', 'ionpeblog' ),
			'tag_archive_prefix'     => __( 'Tag:', 'ionpeblog' ),
			'search_prefix'          => __( 'Search:', 'ionpeblog' ),
			'error_prefix'           => __( '404 - Page not Found', 'ionpeblog' ),
		);

		// Setup a filter for changeable variables and meger it with the defaults
		$defaults = wp_parse_args( $args, $defaults );

		$this->home_prefix            = $defaults['home_prefix'];
		$this->separator              = $defaults['separator'];
		$this->show_post_type_archive = $defaults['show_post_type_archive'];
		$this->show_terms             = $defaults['show_terms'];
		$this->home_label             = $defaults['home_label'];
		$this->tag_archive_prefix     = $defaults['tag_archive_prefix'];
		$this->search_prefix          = $defaults['search_prefix'];
		$this->error_prefix           = $defaults['error_prefix'];
	}

	/**
	 * Publicly accessible function to get the full breadcrumb HTML markup
	 *
	 * @return void
	 */
	public function get_breadcrumbs() {

		// Get the Wordpres SEO options if activated; else will return FALSE
		$options = get_option( 'wpseo_internallinks' );

		// Support for Yoast Breadcrumbs
		if ( function_exists( 'yoast_breadcrumb' ) && $options && $options['breadcrumbs-enable'] === true ) {
			ob_start();
			yoast_breadcrumb();
			$this->html_markup = ob_get_clean();

			// Muscle Core Breadcrumbs
		} else {
			$this->prepare_breadcrumb_html();
		}

		$this->wrap_breadcrumbs();
		$this->output_breadcrumbs_html();
	}

	/**
	 * Prepare the full output of the breadcrumb path
	 *
	 * @return void
	 */
	private function prepare_breadcrumb_html() {
		// Add the path prefix
		$this->html_markup = $this->get_breadcrumb_prefix();

		// Add the "Home" link
		$this->html_markup .= $this->get_breadcrumb_home();

		// Woocommerce path prefix (e.g "Shop" )
		if ( class_exists( 'WooCommerce' ) && ( ( is_woocommerce() && is_archive() && ! is_shop() ) || is_cart() || is_checkout() || is_account_page() ) ) {
			$this->html_markup .= $this->get_woocommerce_shop_page();
		}

		// bbPress path prefix (e.g "Forums" )
		if ( class_exists( 'bbPress' ) && is_bbpress() && ( bbp_is_topic_archive() || bbp_is_single_user() || bbp_is_search() ) ) {
			$this->html_markup .= $this->get_bbpress_main_archive_page();
		}

		// Single Posts and Pages (of all post types)
		if ( is_singular() ) {
			// If the post type of the current post has an archive link, display the archive breadcrumb
			if ( isset( $this->post->post_type ) && get_post_type_archive_link( $this->post->post_type ) && $this->show_post_type_archive ) {
				$this->html_markup .= $this->get_post_type_archive();
			}

			// If the post doesn't have parents
			if ( isset( $this->post->post_parent ) && $this->post->post_parent == 0 ) {
				$this->html_markup .= $this->get_post_terms();
				// If there are parents; mostly for pages
			} else {
				$this->html_markup .= $this->get_post_ancestors();
			}

			$this->html_markup .= $this->get_breadcrumb_leaf_markup();
		} else {
			if ( is_home() && ! is_front_page() ) {
				$this->html_markup .= $this->get_post_type_archive( false );
			} elseif ( is_post_type_archive() ) {
				$this->html_markup .= $this->get_post_type_archive( false );

				// Search on custom post type (e.g. Woocommerce)
				if ( is_search() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'search' );
				}
				// Taxonomy Archives
			} elseif ( is_tax() || is_tag() || is_category() ) {
				// If we have a tag archive, add the tag prefix
				// if ( is_tag() ) {
				// 	$this->html_markup .= $this->tag_archive_prefix;
				// }
				$this->html_markup .= $this->get_taxonomies();
				$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'term' );
				// Date Archives
			} elseif ( is_date() ) {
				global $wp_locale;
				// Set variables
				$year = esc_html( get_query_var( 'year' ) );
				if ( is_month() || is_day() ) {
					$month      = get_query_var( 'monthnum' );
					$month_name = $wp_locale->get_month( $month );
				}
				// Year Archive, only is a leaf
				if ( is_year() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'year' );
					// Month Archive, needs year link and month leaf
				} elseif ( is_month() ) {
					$this->html_markup .= $this->get_single_breadcrumb_markup( $year, get_year_link( $year ) );
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'month' );
					// Day Archive, needs year and month link and day leaf
				} elseif ( is_day() ) {
					$this->html_markup .= $this->get_single_breadcrumb_markup( $year, get_year_link( $year ) );
					$this->html_markup .= $this->get_single_breadcrumb_markup( $month_name, get_month_link( $year, $month ) );
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'day' );
				}
				// Author Archives
			} elseif ( is_author() ) {
				$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'author' );
				// Search Page
			} elseif ( is_search() ) {
				$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'search' );
				// 404 Page
			} elseif ( is_404() ) {
				// Special treatment for Events Calendar to avoid 404 messages on list view
				if ( class_exists( 'TribeEvents' ) && tribe_is_event() || is_events_archive() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'events' );
					// Default case
				} else {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( '404' );
				}
				// bbPress
			} elseif ( class_exists( 'bbPress' ) ) {
				// Search Page
				if ( bbp_is_search() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'bbpress_search' );
					// User page
				} elseif ( bbp_is_single_user() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'bbpress_user' );
				}
			}
		}
	}

	/**
	 * Wrap the breadcrumb path in a div
	 *
	 * @return string The HTML markup of the wrapped breadcrumb path
	 */
	private function wrap_breadcrumbs() {
		$this->html_markup = sprintf( '<div id="breadcrumb"><div class="container"><ul class="hidden-xs">%s</ul></div></div>', $this->html_markup );
	}

	/**
	 * Output the full breadcrumb HTML markup
	 *
	 * @return void
	 */
	private function output_breadcrumbs_html() {
		echo $this->html_markup;
	}

	/**
	 * Get the markup of the breadcrumb path prefix
	 *
	 * @return string The HTML markup of the breadcrumb path prefix
	 */
	private function get_breadcrumb_prefix() {
		$prefix = '';

		// If the home page is a real page
		if ( ! is_front_page() ) {
			// Add chosen path prefix
			if ( $this->home_prefix ) {
				$prefix = sprintf( '<li class="mt-breadcrumb-prefix">%s:</li>', $this->home_prefix );
			}
		}

		return $prefix;
	}

	/**
	 * Get the markup of the "Home" Link
	 *
	 * @return string The HTML markup of the "Home" link
	 */
	private function get_breadcrumb_home() {
		$home_link = '';

		// If the home page is a real page
		if ( ! is_front_page() ) {
			$home_link = $this->get_single_breadcrumb_markup( $this->home_label, get_home_url(), true, true, $this->home_icon );
			// If the home page is the main blog page
		} elseif ( is_home() ) {
			$home_link = $this->get_single_breadcrumb_markup( __( 'Blog', 'ionpeblog' ) );
		}

		return $home_link;

	}

	/**
	 * Construct the full post term tree path and add its HTML markup
	 *
	 * @return string The HTML markup of the full term breadcrumb path
	 */
	private function get_post_terms() {
		$terms_markup = '';

		// If terms are disabled, nothing is to do
		if ( ! $this->show_terms ) {
			return $terms_markup;
		}

		// Get the post terms
		if ( $this->post->post_type == 'post' ) {
			$taxonomy = 'category';

			/*
			// Muscle Core Portfolio
			} elseif ( $this->post->post_type == 'project' ) {
				$taxonomy = 'project_category';
			*/

			// Woocommerce
		} elseif ( $this->post->post_type == 'product' && class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			$taxonomy = 'product_cat';
			// The Events Calendar
		} elseif ( $this->post->post_type == 'tribe_events' ) {
			$taxonomy = 'tribe_events_cat';
			// For other post types don't return a terms tree to reduce possible errors
		} else {
			return $terms_markup;
		}

		$terms = wp_get_object_terms( $this->post->ID, $taxonomy );

		// If post does not have any terms assigned; possible e.g. portfolio posts
		if ( empty( $terms ) ) {
			return $terms_markup;
		}

		// Check if the terms are all part of one term tree, i.e. only related terms are selected
		$terms_by_id = array();
		foreach ( $terms as $term ) {
			$terms_by_id[ $term->term_id ] = $term;
		}

		// Unset all terms that are parents of some term
		foreach ( $terms as $term ) {
			unset( $terms_by_id[ $term->parent ] );
		}

		// If only one term is left, we have a single term tree
		if ( count( $terms_by_id ) == 1 ) {
			unset( $terms );
			$terms[0] = array_shift( $terms_by_id );
		}

		// The post is only in one term
		if ( count( $terms ) == 1 ) {

			$term_parent = $terms[0]->parent;

			// If the term has a parent we need its ancestors for a full tree
			if ( $term_parent ) {
				// Get space separated string of term tree in slugs
				$term_tree   = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree   = array_reverse( $term_tree );
				$term_tree[] = get_term( $terms[0]->term_id, $taxonomy );

				// Loop through the term tree
				foreach ( $term_tree as $term_id ) {
					// Get the term object by its slug
					$term_object = get_term( $term_id, $taxonomy );

					// Add it to the term breadcrumb markup string
					$terms_markup .= $this->get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object ) );
				}
				// We have a single term, so put it out
			} else {
				$terms_markup = $this->get_single_breadcrumb_markup( $terms[0]->name, get_term_link( $terms[0] ) );
			}
			// The post has multiple terms
		} else {
			// The lexicographically smallest term will be part of the breadcrump rich snippet path
			$terms_markup = $this->get_single_breadcrumb_markup( $terms[0]->name, get_term_link( $terms[0] ), false );
			// Drop the first index
			array_shift( $terms );

			// Loop through the rest of the terms, and add them to string comma separated
			$max_index = count( $terms );
			$i         = 0;
			foreach ( $terms as $term ) {

				// For the last index also add the separator
				if ( ++ $i == $max_index ) {
					$terms_markup .= ', ' . $this->get_single_breadcrumb_markup( $term->name, get_term_link( $term ), true, false );
				} else {
					$terms_markup .= ', ' . $this->get_single_breadcrumb_markup( $term->name, get_term_link( $term ), false, false );
				}
			}
		}

		return $terms_markup;
	}

	/**
	 * Construct the full post ancestors tree path and add its HTML markup
	 *
	 * @return string The HTML markup of the ancestors tree
	 */
	private function get_post_ancestors() {
		$ancestors_markup = '';

		// Get the ancestor id, order needs to be reversed
		$post_ancestor_ids = array_reverse( get_post_ancestors( $this->post ) );

		// Loop through the ids to get the full tree
		foreach ( $post_ancestor_ids as $post_ancestor_id ) {
			$post_ancestor = get_post( $post_ancestor_id );
			$ancestors_markup .= $this->get_single_breadcrumb_markup( $post_ancestor->post_title, get_permalink( $post_ancestor->ID ) );
		}

		return $ancestors_markup;
	}

	/**
	 * Construct the full term ancestors tree path and add its HTML markup
	 *
	 * @return string The HTML markup of the term ancestors tree
	 */
	private function get_taxonomies() {
		global $wp_query;
		$term         = $wp_query->get_queried_object();
		$terms_markup = '';

		// Make sure we have hierarchical taxonomy and parents
		if ( $term->parent != 0 && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
			$term_ancestors = array_reverse( $term_ancestors );
			// Loop through ancestors to get the full tree
			foreach ( $term_ancestors as $term_ancestor ) {
				$term_object = get_term( $term_ancestor, $term->taxonomy );
				$terms_markup .= $this->get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
			}
		}

		return $terms_markup;
	}

	/**
	 * Adds the markup of a post type archive
	 *
	 * @return string The HTML markup of the post type archive
	 */
	private function get_post_type_archive( $linked = true ) {
		global $wp_query;

		$post_type        = $wp_query->query_vars['post_type'];
		$post_type_object = get_post_type_object( $post_type );
		$link             = '';

		// Check if we have a post type object
		if ( is_object( $post_type_object ) ) {

			// Woocommerce: archive name should be same as shop page name
			if ( $post_type == 'product' && $woocommerce_shop_page = $this->get_woocommerce_shop_page( $linked ) ) {
				return $woocommerce_shop_page;
			}

			// bbPress: make sure that the Forums slug and link are correct
			if ( class_exists( 'bbPress' ) && $post_type == 'topic' ) {
				$archive_title = bbp_get_forum_archive_title();
				if ( $linked ) {
					$link = get_post_type_archive_link( bbp_get_forum_post_type() );
				}

				return $this->get_single_breadcrumb_markup( $archive_title, $link );
			}

			// Default case
			// Check if the post type has a non empty label
			if ( isset( $post_type_object->label ) && $post_type_object->label !== '' ) {
				$archive_title = $post_type_object->label;
				// Alternatively check for a non empty menu name
			} elseif ( isset( $post_type_object->labels->menu_name ) && $post_type_object->labels->menu_name !== '' ) {
				$archive_title = $post_type_object->labels->menu_name;
				// Use its name as fallback
			} else {
				$archive_title = $post_type_object->name;
			}
		}

		// Check if the breadcrumb should be linked
		if ( $linked ) {
			$link = get_post_type_archive_link( $post_type );
		}

		$page_id = get_option( 'page_for_posts' );

		if ( $post_type == '' && $page_id ) {
			$archive_title = get_the_title( $page_id );
			if ( $linked ) {
				$link          = get_permalink( $page_id );
			}
		} elseif ( $post_type == 'post' ) {
			$archive_title = __( 'Acasă', 'ionpeblog' );
			if ( $linked ) {
				$link          = site_url( $page_id );
			}
		} elseif ( $post_type == '' && ! $page_id ) {
			return;
		}


		return $this->get_single_breadcrumb_markup( $archive_title, $link );
	}

	/**
	 * Adds the markup of the woocommerce shop page
	 *
	 * @return string The HTML markup of the woocommerce shop page
	 */
	private function get_woocommerce_shop_page( $linked = true ) {
		global $wp_query;

		$post_type        = 'product';
		$post_type_object = get_post_type_object( $post_type );
		$shop_page_markup = $link = '';

		// Make sure we are on a woocommerce page
		if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			// Get shop page id and then its name
			$shop_page_id   = wc_get_page_id( 'shop' );
			$shop_page_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			// Use the archive name if no shop page was set.
			if ( ! $shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}

			// Check if the breadcrumb should be linked
			if ( $linked ) {
				$link = get_post_type_archive_link( $post_type );
			}

			$shop_page_markup = $this->get_single_breadcrumb_markup( $shop_page_name, $link );
		}

		return $shop_page_markup;
	}

	/**
	 * Adds the markup of the bbpress main forum archive
	 *
	 * @return string The HTML markup of the bbpress main forum archive
	 */
	private function get_bbpress_main_archive_page() {
		global $wp_query;

		return $this->get_single_breadcrumb_markup( bbp_get_forum_archive_title(), get_post_type_archive_link( 'forum' ) );
	}

	/**
	 * Adds the markup of the breadcrumb leaf
	 *
	 * @param  string $object_id ID of the current query object
	 *
	 * @return string                The HTML markup of the breadcrumb leaf
	 */
	private function get_breadcrumb_leaf_markup( $object_type = '' ) {
		global $wp_query, $wp_locale;

		switch ( $object_type ) {
			case 'term':
				$term  = $wp_query->get_queried_object();
				$title = $term->name;
				break;
			case 'year':
				$title = esc_html( get_query_var( 'year' ) );
				break;
			case 'month':
				$title = $wp_locale->get_month( get_query_var( 'monthnum' ) );
				break;
			case 'day':
				$title = get_query_var( 'day' );
				break;
			case 'author':
				$user  = $wp_query->get_queried_object();
				$title = $user->display_name;
				break;
			case 'search':
				$title = sprintf( '%s %s', $this->search_prefix, esc_html( get_search_query() ) );
				break;
			case '404':
				$title = $this->error_prefix;
				break;
			case 'bbpress_search':
				$title = sprintf( '%s %s', $this->search_prefix, esc_html( get_query_var( 'bbp_search' ) ) );
				break;
			case 'bbpress_user':
				$current_user = wp_get_current_user();
				$title        = $current_user->user_nicename;
				break;
			case 'events':
				$title = tribe_get_events_title();
				break;
			default:
				$title = get_the_title( $this->post->ID );
				break;
		}

		return sprintf( '<li class="breadcrumb-leaf">%s</li>', $title );
	}

	/**
	 * Adds the markup of a single breadcrumb
	 *
	 * @param  string  $title     The title that should be displayed
	 * @param  string  $link      The URL of the breadcrumb
	 * @param  boolean $separator Set to TRUE to show the separator at the end of the breadcrumb
	 * @param boolean  $microdata Set to FALSE to make sure we get a link not being part of the breadcrumb microdata
	 *                            path
	 *
	 * @return string                The HTML markup of a single breadcrumb
	 */
	private function get_single_breadcrumb_markup( $title, $link = '', $separator = true, $microdata = true, $icon = '' ) {

		// Init vars
		$microdata_itemscope = $microdata_url = $microdata_title = $separator_markup = '';

		// Setup the elements attributes for breadcrumb microdata rich snippets
		if ( $microdata ) {
			$microdata_itemscope = 'itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
			$microdata_url       = 'itemprop="url"';
			$microdata_title     = 'itemprop="title"';
		}

		$breadcrumb_content = sprintf( '<span %s>%s</span>', $microdata_title, $title );

		// If a link is set add its markup
		if ( $link ) {
			$breadcrumb_content = sprintf( '<a %s href="%s" >%s%s</a>', $microdata_url, $link, $icon, $breadcrumb_content );
		}

		return sprintf( '<li %s>%s</li>', $microdata_itemscope, $breadcrumb_content );
	}
}
