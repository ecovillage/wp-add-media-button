<?php
/**
 * @package Add_Media_Buttons
 * @version 0.5
 */
/*
Plugin Name: Add Media Buttons
Plugin URI: http://www.siebenlinden.org
Description: This plugin adds two 'add media'-buttons (add image left/right) to the WordPress editor. It's purpose is the support of the authors of the Sieben Linden website with a convenient tool to insert custom style images into posts and articles.  
Author: Holger Nassenstein, Felix Wolfsteller
Version: 0.5
License: GPL2+
*/

/*
 * TODO:
 	* Parameter delivery php->js for thumbnail-size 
*/


// Two additional add-media buttons for Tiny MCE:

add_action('media_buttons', 'add_my_media_buttons', 15);

function add_my_media_buttons(){
    echo '<a href="#" id="insert-my-media-left" class="button">Bild links einfügen</a>';
    echo '<a href="#" id="insert-my-media-right" class="button">Bild rechts einfügen</a>';
}


// Hook javascript functions to the onclick event of the buttons above 

add_action('wp_enqueue_media', 'include_media_button_js_file');

function include_media_button_js_file(){
    wp_enqueue_script('media_button', plugins_url( 'js/media_button.js',  __FILE__ ), array('jquery'), '1.0', true);
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// admin menu
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/** Set Defaults **/
add_option( 'add_media_buttons_field_1', '1' );

/** Add Settings Page **/
function add_media_buttons_setup_menu() {
 
    add_options_page(
    /*1*/   'Add Media Buttons Settings',
    /*2*/   'Add Media Buttons',
    /*3*/   'manage_options',
    /*4*/   'add_media_buttons_settings',
    /*5*/   'add_media_buttons_settings_page'
    );
 
}
add_action('admin_menu', 'add_media_buttons_setup_menu');
 
/** Settings Page Content **/
function add_media_buttons_settings_page() {
 
    ?>
 
    <div class="wrap">
        <?php 
         
        // Uncomment if this screen isn't added with add_options_page() 
        // settings_errors(); 
         
        ?>
 
        <h2>Add Media Buttons</h2>
        <p>Größe der Verschaubilder der Buttons 'Bild (rechts/links) hinzufügen' in TinyMCE</p>
 
        <form method="post" action="options.php">
            <?php
 
            // Output the settings sections.
            do_settings_sections( 'add_media_buttons_settings' );
 
            // Output the hidden fields, nonce, etc.
            settings_fields( 'add_media_buttons_settings_group' );
 
            // Submit button.
            submit_button();
 
            ?>
        </form>
    </div>
 
    <?php
}
/** Settings Initialization **/
function add_media_buttons_settings_init() {
 
    
   /** Section 1 **/
    add_settings_section(
    /*1*/   'add_media_buttons_settings_section_1',
    /*2*/   '',
    /*3*/   'add_media_buttons_settings_section_1_callback',
    /*4*/   'add_media_buttons_settings'
    );
     
    // Field 1.
    add_settings_field(
    /*1*/   'add_media_buttons_field_1',
    /*2*/   '',
    /*3*/   'add_media_buttons_field_1_input',
    /*4*/   'add_media_buttons_settings',
    /*5*/   'add_media_buttons_settings_section_1'
    );
 
    // Register this field with our settings group.
    register_setting( 'add_media_buttons_settings_group', 'add_media_buttons_field_1' );  
     
}
add_action( 'admin_init', 'add_media_buttons_settings_init' );
 

function add_media_buttons_settings_section_1_callback() {
 
//    echo( 'An explanation of this section.' );
}

 

/** Field 1 Input **/
function add_media_buttons_field_1_input() {
 
    // This example input will be a dropdown.
    // Available options.
    $options = array(
	'1' => 'thumbnail',
	'2' => 'medium',
	'3' => 'medium_large',
	'4' => 'large',
	'5' => 'full',
    );
     
    // Current setting.
    $current = get_option( 'add_media_buttons_field_1' );
     
    // Build <select> element.
    $html = '<select id="add_media_buttons_field_1" name="add_media_buttons_field_1">';
 
    foreach ( $options as $value => $text )
    {
        $html .= '<option value="'. $value .'"';
 
        // We make sure the current options selected.
        if ( $value == $current ) $html .= ' selected="selected"';
 
        $html .= '>'. $text .'</option>';
    }
     
    $html .= '</select>';
 
    echo( $html );  
}
 


