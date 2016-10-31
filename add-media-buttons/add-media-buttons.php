<?php
/**
 * @package Add_Media_Buttons
 * @version 0.7
 */
/*
Plugin Name: Add Media Buttons
Plugin URI: http://www.siebenlinden.org
Description: This plugin adds two 'add media'-buttons (add image left/right) to the WordPress editor. It's purpose is the support of the authors of the Sieben Linden website with a convenient tool to insert custom style images into posts and articles.  
Author: Holger Nassenstein, Felix Wolfsteller
Version: 0.7
License: GPL2+
*/

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// globals:
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

$options = array(0, 'thumbnail', 'medium', 'large', 'full');
// index; thumbnail sizes for admin dropdown menu

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Two additional add-media buttons for Tiny MCE:
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



function add_my_media_buttons(){
    echo '<a href="#" id="insert-my-media-left" class="button">Bild links einfügen</a>';
    echo '<a href="#" id="insert-my-media-right" class="button">Bild rechts einfügen</a>';
}
add_action('media_buttons', 'add_my_media_buttons', 15);


// Hook javascript functions to the onclick event of the buttons above 


function include_media_button_js_file(){
  global $options;
  wp_enqueue_script('media_button', plugins_url( 'js/media_button.js',  __FILE__ ), array('jquery'), '1.0', true);
  // get the index of the current selection in the admin menu: 
  $options[0] = get_option( 'add_media_buttons_field_1' );
  $json_str = json_encode($options);
  // encode global array '$options' to json array
  $params = array(
    'php_arr' => $json_str,
  );
  // now pass '$params' to the enqueued js-script.
  // In the js.script access to $json_str is possible via 'AddMediaButtonParams.php_arr'
  wp_localize_script( 'media_button', 'AddMediaButtonParams', $params );
}
add_action('wp_enqueue_media', 'include_media_button_js_file');




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
            submit_button('Einstellungen speichern');
 
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
    // section title empty, 'cause there is just one section
    /*3*/   'add_media_buttons_settings_section_1_callback',
    /*4*/   'add_media_buttons_settings'
    );
     
    // Field 1.
    add_settings_field(
    /*1*/   'add_media_buttons_field_1',
    /*2*/   '',
    // field title empty, 'cause there is just one field
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
   // Available options for admin dropdown menu.
  global $options;
   
  // Current setting.
  $options[0] = get_option( 'add_media_buttons_field_1' );
     
  // Build <select> element.
  $html = '<select id="add_media_buttons_field_1" name="add_media_buttons_field_1">';
 
  foreach ( $options as $key => $value )
  {
    if ( $key == 0 )
      continue;

    $html .= '<option value="'. $key .'"';
 
    // We make sure the current options selected.
    if ( $key == $options[0] ) $html .= ' selected="selected"';
 
    $html .= '>'. $value .'</option>';
  }
     
  $html .= '</select>';
 
  echo( $html );  
}
 

