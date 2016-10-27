<?php
/**
 * @package Add_Media_Buttons
 * @version 0.1
 */
/*
Plugin Name: Add Media Buttons
Plugin URI: http://www.siebenlinden.org
Description: This plugin adds two 'add media'-buttons (add image left/right) to the WordPress editor. It's purpose is the support of the authors of the Sieben Linden website with a convenient tool to insert custom style images into posts and articles.  
Author: Holger Nassenstein
Version: 0.2
*/

// Two additional add-media buttons for Tiny MCE:

add_action('media_buttons','add_my_media_buttons',15);

function add_my_media_buttons(){
    echo '<a href="#" id="insert-my-media-left" class="button">Bild links einfügen</a>';
    echo '<a href="#" id="insert-my-media-right" class="button">Bild rechts einfügen</a>';
}


// Hook javascript functions to the onclick event of the buttons above 

add_action('wp_enqueue_media','include_media_button_js_file');

function include_media_button_js_file(){
    wp_enqueue_script('media_button',plugins_url( 'js/media_button.js', __FILE__ ),array('jquery'),'1.0',true);
}

?>
