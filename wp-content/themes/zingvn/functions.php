<?php

function zingvn_resources(){
	wp_enqueue_style ('style', get_template_directory_uri().'/style.css');
}

add_action('wp_enqueue_scripts','zingvn_resources');

	// Navigation menus 
register_nav_menus(array(
	'primary' => __('Primary Menu'),
	'footer' => __('Footer Menu')
));

	// Get top ancestor id
function get_top_ancestor_id(){
	global $post;
	if($post->post_parent){
		$ancestors= array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
	}	
	return $post->ID;
}

	// Does page have children ? 
function has_children(){
	global $post;
	$pages = get_pages('child_of=' . $post->ID);
	return count($pages);
}

	// Customize excerpt word count length
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

	// ADD FEATURED IMAGE SUPPORT
function featured_images_setup(){
	add_theme_support('post-thumbnails');
  add_image_size( 'thumbnail',300, 250, true ); //thumbnail
    add_image_size( 'medium', 600, 400, true ); //medium
    add_image_size( 'large', 1200, 800, true ); //large
}
add_action('after_setup_theme','featured_images_setup');

	// ADD POST FORMAT SUPPORT
add_theme_support('post-formats',array('aside','gallery','link'));

	// ADD OUR WIDGETS LOCATION
function our_widget_inits(){
    register_sidebar(array(
    'name' => 'Sidebar_Index_Top',
    'id' => 'sidebar_index_top',
    'before_widget' => '<div id="%1$s" class="widget %2$s widget_area">',
    'after_widget' => "</div>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));

	register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div id="%1$s" class="widget %2$s widget_area">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer area 1',
		'id' => 'footer1',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer area 2',
		'id' => 'footer2',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer area 3',
		'id' => 'footer3',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init','our_widget_inits');




/** Filter & Hook In Widget Before Post Content .*/
function before_post_widget() {


	if ( is_home() && is_active_sidebar( 'sidebar1' ) ) { 
		dynamic_sidebar('sidebar1', array(
			'before' => '<div class="before-post">',
			'after' => '</div>',
		) );      
	}

}

add_action( 'woo_loop_before', 'before_post_widget' );


// ADD THEME CUSTOM LOGO
add_theme_support( 'custom-logo' );


	//  ADD BREADCRUMB
if ( ! function_exists( 'breadcrumbs' ) ) :
    /**
     * Prints HTML.
     */
    function breadcrumbs() {
        $delimiter = '';
        $name = 'Trang chủ'; //text for the 'Home' link
        $currentBefore = '<li><span class="current">';
        $currentAfter = '</span></li>';
        global $post;
        $home = get_bloginfo('url');
        
        if(is_home() && get_query_var('paged') == 0) 
            echo '<span class="home">' . $name . '</span>';
        else
            echo '<li><a class="home" href="' . $home . '">' . $name . '</a> </li> '. $delimiter . ' ';
        if ( is_category() ) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $currentBefore;
            single_cat_title();
            echo $currentAfter;
      
        } elseif ( is_single() ) {
          $cat = get_the_category(); $cat = $cat[0];
          echo '<li>';
          echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
          echo '</li>';
          echo $currentBefore;
          the_title();
          echo $currentAfter;
      
        } elseif ( is_page() && !$post->post_parent ) {
          echo $currentBefore;
          the_title();
          echo $currentAfter;
      
        } elseif ( is_page() && $post->post_parent ) {
          $parent_id  = $post->post_parent;
          $breadcrumbs = array();
          while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
            $parent_id  = $page->post_parent;
          }
          $breadcrumbs = array_reverse($breadcrumbs);
          foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
          echo $currentBefore;
          the_title();
          echo $currentAfter;
      
        } elseif ( is_search() ) {
          echo $currentBefore . 'Search for ' . get_search_query() . $currentAfter;
      
        } elseif ( is_tag() ) {
          echo $currentBefore;
          single_tag_title();
          echo $currentAfter;
      
        } elseif ( is_author() ) {
           global $author;
          $userdata = get_userdata($author);
          echo $currentBefore. $userdata->display_name . $currentAfter;
      
        } elseif ( is_404() ) {
          echo $currentBefore . 'Error 404' . $currentAfter;
        }
      
        if ( get_query_var('paged') )
          echo $currentBefore . __('Page') . ' ' . get_query_var('paged') . $currentAfter;
    }
	endif;



/*
 *  DUPLICATE POST IN  ADMIN. Dups appear as drafts. User is redirected to the edit screen
 */
function rd_duplicate_post_as_draft(){
  global $wpdb;
  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }
 
  /*
   * Nonce verification
   */
  if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
    return;
 
  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
  /*
   * and all the original post data then
   */
  $post = get_post( $post_id );
 
  /*
   * if you don't want current user to be the new post author,
   * then change next couple of lines to this: $new_post_author = $post->post_author;
   */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
 
  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {
 
    /*
     * new post data array
     */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );
 
    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post( $args );
 
    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }
 
    /*
     * duplicate all post meta just in two SQL queries
     */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos)!=0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        if( $meta_key == '_wp_old_slug' ) continue;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }
 
 
    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
  if (current_user_can('edit_posts')) {
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Nhân bản</a>';
  }
  return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

// duplicate page
//add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);

  define('BASE_URL', get_site_url('null','/wp-content/themes/zingvn', 'http'));



//view 
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
        return "1";
    }
    return $count.'';
}
//end view


// SHOW LIST SUBCATEGORY
class ListCategories{
  static function list_categories($atts, $content = null) {
    $atts = shortcode_atts(
      array(
        'show_option_all'    => '',
        'orderby'            => 'name',
        'order'              => 'ASC',
        'style'              => 'list',
        'show_count'         => 0,
        'hide_empty'         => 1,
        'use_desc_for_title' => 1,
        'child_of'           => 0,
        'feed'               => '',
        'feed_type'          => '',
        'feed_image'         => '',
        'exclude'            => '',
        'exclude_tree'       => '',
        'include'            => '',
        'hierarchical'       => 1,
        'title_li'           => __( '' ),
        'show_option_none'   => __( '' ),
        'number'             => null,
        'echo'               => 1,
        'depth'              => 1,
        'current_category'   => 1,
        'pad_counts'         => 0,
        'taxonomy'           => 'category',
        'walker'             => null
      ), $atts
    );

    ob_start();
    wp_list_categories($atts);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }
}
add_shortcode( 'list_catgory', array('ListCategories', 'list_categories') );
// END SHOW LIST SUBCATEGORY


function sm_custom_meta() {
    add_meta_box( 'sm_meta', __( 'Featured Posts', 'sm-textdomain' ), 'sm_meta_callback', 'post' );
}
function sm_meta_callback( $post ) {
    $featured = get_post_meta( $post->ID );
    ?>
 
  <p>
    <div class="sm-row-content">
        <label for="meta-checkbox">
            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $featured['meta-checkbox'] ) ) checked( $featured['meta-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Featured this post', 'sm-textdomain' )?>
        </label>
        
    </div>
</p>
 
<?php }
add_action( 'add_meta_boxes', 'sm_custom_meta' );

/**
 * Saves the custom meta input
 */
function sm_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
 // Checks for input and saves
if( isset( $_POST[ 'meta-checkbox' ] ) ) {
    update_post_meta( $post_id, 'meta-checkbox', 'yes' );
} else {
    update_post_meta( $post_id, 'meta-checkbox', '' );
}
 
}
add_action( 'save_post', 'sm_meta_save' );





?>




