<?php 
/********************************************************
 *  
 *          THIS FILE IS FOR DEREGISTERING AND REMOVING ACTIONS
 *          THAT WOULD OTHERWISE SLOW-DOWN THE WEBSITES SPEED.
 *          -Aaron
 * 
 ********************************************************/
// remove emoji enqueues 
function disable_wp_emojicons() {
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  
    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
  }
  add_action( 'init', 'disable_wp_emojicons' );
  // disable tinymce emojis
  function disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }
// deregister wp-embed.js (not fetching embeds from other wp site so will speed site up by removing)
  function my_deregister_scripts(){
    wp_deregister_script( 'wp-embed' );
  }
    add_action( 'wp_footer', 'my_deregister_scripts' );
    
    add_action('init', 'remove_content_editor');
    function remove_content_editor() {
            remove_post_type_support( 'page', 'editor' );
            remove_post_type_support( 'page', 'thumbnail' );
    }
    // Stop Contact Form 7 Loading on anypage 
    add_filter( 'wpcf7_load_js', '__return_false' );
    add_filter( 'wpcf7_load_css', '__return_false' );
//remove js-migrate
    add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );
function dequeue_jquery_migrate( &$scripts){
    if(!is_admin()){
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
}