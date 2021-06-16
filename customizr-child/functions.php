<?php
//require get_theme_file_path( '/dBug.php' );

	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'customizr-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

function revilodesign_rename_post_menu() {
	global $menu;
	$menu[5][0] = 'News'; // Änderung von "Beiträge" in "Kunden
	}
add_action( 'admin_menu', 'revilodesign_rename_post_menu' );

function revilodesign_rename_dashboard_menu( $revilodesign_rename_item ) 
{  
    $revilodesign_rename_item = str_replace( 'Beiträge', 'News', $revilodesign_rename_item );
    $revilodesign_rename_item = str_replace( 'beitraege', 'News', $revilodesign_rename_item );
    return $revilodesign_rename_item;
}
add_filter( 'gettext', 'revilodesign_rename_dashboard_menu' );
add_filter( 'ngettext', 'revilodesign_rename_dashboard_menu' );


add_shortcode( 'top-menu', 'get_the_topmenu' );

function wpb_custom_new_menu() {
  register_nav_menus(
    array(
      'footer-menu' => __( 'Footer Menu' )
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );

function get_the_topmenu(){
	$return = '<div class="topmenu">
			        '.
						wpse_get_ancestor_tree()
					.'
			        
		        </div>';
	return $return;
}

/**
 * Use wp_list_pages() to display parent and all child pages of current page.
 */
function wpse_get_ancestor_tree() {
	
	$depth = get_current_page_depth(); 
    $post = get_post();
    if($depth >1){
	    $id = $post->post_parent;
    }else{
	    $id = $post->ID;
    }

    $output = wp_list_pages(array(
	    'child_of' => $id,
	    'echo' => false,
	    'title_li' => false,
	    'sort_column'  => 'menu_order, date',

	    'sort_order' => 'desc'
	));
	
	
	
	
    if ( ! $output ) {
        return false;
    } else { 
        return '<ul class="page-menu ancestor-tree">' . PHP_EOL .
                            $output . PHP_EOL .
                        '</ul>' . PHP_EOL;
    }
}

//Page Slug Body Class
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

add_action( 'enqueue_block_editor_assets', 'photographus_add_gutenberg_assets' );

/**
 * Load Gutenberg stylesheet.
 */
function photographus_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'photographus-gutenberg', get_theme_file_uri( '/editor-style.css' ), false );
}

function get_current_page_depth(){
    global $wp_query;
     
    $object = $wp_query->get_queried_object();
    $parent_id  = $object->post_parent;
    $depth = 0;
    while($parent_id > 0){
        $page = get_page($parent_id);
        $parent_id = $page->post_parent;
        $depth++;
    }
  
    return $depth;
}

?>