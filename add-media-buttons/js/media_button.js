/*
  Callback, receives selected media, returns html code representing clickable
  media.
  selected - media (usually image) reference.
  align    - css class used for the img tag.
*/

function evalselection(selected,align) {
  // the one and only parameter from registering php-script: AddMediaButtonParams
  // Defined in initializing PHP-script as follows:
  // $options = array(0, 'thumbnail', 'medium', 'large', 'full');
  // index; thumbnail sizes for admin dropdown menu

  var php_arr = jQuery.parseJSON(AddMediaButtonParams.php_arr);
  // decode json array
  var index = php_arr[0];
  // first element is the index of the chosen thumbnail size in admin menu 
  var size = php_arr[index];
  // var 'size' now contains the chosen thumbnail size (thumbnail, medium ...)
  var alt = selected.alt;
  if (0 === alt.length){
    alt = selected.name;
    alt = alt.toUpperCase();
  }
  // Log JSON array to console:
  // console.log(JSON.stringify(selected));
  return('<a href="' + selected.url + '"><img src="' +
    selected.sizes[size].url + '" alt="' + alt + '" width="' +
    selected.sizes[size].width + '" height="' +
    selected.sizes[size].height + '" class="' + align + ' size-' +
    size + ' wp-image-' + selected.id + '" /></a>');
}

jQuery(function($) {
    // Register click handlers for new buttons.
    $(document).ready(function(){
           $('#insert-my-media-left').click(open_media_window_left);
           $('#insert-my-media-right').click(open_media_window_right);
        });

    function open_media_window_left() {
        if (this.window === undefined) {
           this.window = wp.media({
                title: 'Bild linksbündig in den Text einfügen',
                library:   wp.media.query({ type: 'image' }),
                multiple: false,
                button: {text: 'Bild links einfügen'}
            });

        // Need variable for anonymous function.
        var media_selection_window = this.window;
        this.window.on('select', function() {
                // "alignleft|aligncenter|alignright"
                wp.media.editor.insert(evalselection(media_selection_window.state().get('selection').first().toJSON(), 'alignleft'));
            });
        }

        this.window.open();
        return false;
    }

    function open_media_window_right() {
        if (this.window === undefined) {
           this.window = wp.media({
                title: 'Bild rechtsbündig in den Text einfügen',
                library:   wp.media.query({ type: 'image' }),
                multiple: false,
                button: {text: 'Bild rechts einfügen'}
            });

        // Need variable for anonymous function.
        var media_selection_window = this.window;
        this.window.on('select', function() {
                // "alignleft|aligncenter|alignright"
                wp.media.editor.insert(evalselection(media_selection_window.state().get('selection').first().toJSON(), 'alignright'));
            });
        }

        this.window.open();
        return false;
    }
});
