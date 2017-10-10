<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

register_sidebar(array(
    'id' => 'top-header-left',
    'name' => 'Top Header Left',
    'before_widget' => '<div id="%1$s" class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  
 register_sidebar(array(
    'id' => 'top-header-right',
    'name' => 'Top Header Right',
    'before_widget' => '<div id="%1$s" class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  
function mv_browser_body_class($classes) {
        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
        if($is_lynx) $classes[] = 'lynx';
        elseif($is_gecko) $classes[] = 'gecko';
        elseif($is_opera) $classes[] = 'opera';
        elseif($is_NS4) $classes[] = 'ns4';
        elseif($is_safari) $classes[] = 'safari';
        elseif($is_chrome) $classes[] = 'chrome';
        elseif($is_IE) {
                $classes[] = 'ie';
                if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
                $classes[] = 'ie'.$browser_version[1];
        } else $classes[] = 'unknown';
        if($is_iphone) $classes[] = 'iphone';
        if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
                 $classes[] = 'osx';
           } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
                 $classes[] = 'linux';
           } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
                 $classes[] = 'windows';
           }
        return $classes;
}
add_filter('body_class','mv_browser_body_class');

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

function recentPosts()
{
        ob_start();
		$args=array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 10
		);
	
		$my_query = new WP_Query($args);
		if($my_query->have_posts()) 
		{
			//echo '<h2 class="widgettitle">News</h2>'; 
			echo ' <div class="row latest-news">
		 <div class="large-12 columns">
		 <div class="owl-carousel owl-theme">';
			while ($my_query->have_posts()) : $my_query->the_post(); 
			echo '<div class="item">';
			?>
			<div class="news-img">
			    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'wpbs-featured' ); ?></a>
			    </div>
			 <div class="news-content">
			<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<div class="post-mata">
			<span class="date">
			    <i class="fusion-li-icon fa fa-calendar"></i> <?php the_time('d-m-Y') ?>
			    </span>
			 <span class="post-by"><i class="fusion-li-icon fa fa-user"></i> <?php the_author(); ?></span>
			  </div>
		  	 <?php the_excerpt(); ?>
		  	  <a class="cta-orange fright" href="<?php the_permalink() ?>" rel="bookmark">Read More</a>
		  	  </div>
			<?php
		
			echo '</div>';
			endwhile;
			echo '</div></div> </div>'; 
		}
	 $output = ob_get_clean();
     return $output;
 
}
add_shortcode('recentNews', 'recentPosts');

/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Team', 'Post Type General Name', 'Avada' ),
        'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'Avada' ),
        'menu_name'           => __( 'Team', 'Avada' ),
        'parent_item_colon'   => __( 'Parent Movie', 'Avada' ),
        'all_items'           => __( 'All Team', 'Avada' ),
        'view_item'           => __( 'View Team', 'Avada' ),
        'add_new_item'        => __( 'Add New Team', 'Avada' ),
        'add_new'             => __( 'Add New', 'Avada' ),
        'edit_item'           => __( 'Edit Team', 'Avada' ),
        'update_item'         => __( 'Update Team', 'Avada' ),
        'search_items'        => __( 'Search Team', 'Avada' ),
        'not_found'           => __( 'Not Found', 'Avada' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'Avada' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'team', 'Avada' ),
        'description'         => __( 'Team Content', 'Avada' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'team', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );

function meetTeam()
	{
		global $post;
		$html ="";
		$args=array(
		'post_type' => 'team',
		'post_status' => 'publish',
		'order' => 'asc',
		'posts_per_page' => 30,
		'posts_per_page' => 30,
		 
		);
		$my_query = null;
		$my_query = new WP_Query($args);
		if($my_query->have_posts()) 
		{
			$html .= ' <div id="team-content" class="content horizontal-images"> <ul><div class="abc">';
			while ($my_query->have_posts()) : $my_query->the_post(); 
			
	
			
			$html .= '<li class="col-team">';
						
			$html .= '<div class="thum"><img src="'.get_the_post_thumbnail_url( $post->ID ,'post-thumbnail' ).'"';
		$html .= '</div>';
			$html .= '<div class="team-info overlay"><h4>'.$post->post_title.'</h4>' .$post->post_content.'</div>';
			$html .= '</li>';
			endwhile;
		   $html .= '</div></ul></div>'; 
		}
		wp_reset_query();  // Restore global post data stomped by the_post().
return $html;
	}
add_shortcode('meetTeam', 'meetTeam');
