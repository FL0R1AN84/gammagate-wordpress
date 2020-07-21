<?php
// Child Theme
function child_theme_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
wp_enqueue_style( 'child-theme-css', get_stylesheet_directory_uri() .'/style.css' , array('parent-style'));

}
add_action( 'wp_enqueue_scripts', 'child_theme_styles' );

// Comments, disable field for the web page (URL)
add_action( 'after_setup_theme', 'tu_add_comment_url_filter' );
function tu_add_comment_url_filter() {
    add_filter( 'comment_form_default_fields', 'tu_disable_comment_url', 20 );
}

function tu_disable_comment_url($fields) {
    unset($fields['url']);
    return $fields;
}

// Remove IP from Comments
function  wpb_remove_commentsip( $comment_author_ip ) {
	return 'x.x.x.x';
	}
add_filter( 'pre_comment_user_ip', 'wpb_remove_commentsip' ); 

// REST API, hide users
add_filter( 'rest_endpoints', function( $endpoints ){
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
}); 

// WordPress Updates include for Themes and Plugins
define( 'WP_AUTO_UPDATE_CORE', true );
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
?>