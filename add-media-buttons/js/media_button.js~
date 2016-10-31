/*
  Callback, receives selected media, returns html code representing clickable
  media.
  selected - media (usually image) reference.
  align    - css class used for the img tag.
*/

function evalselection(selected,align) {
  var options = new Array('thumbnail', 'medium', 'large', 'full');
  var size = options[AddMediaButtonParams];
  // the one and only parameter from registering php-script: AddMediaButtonParams
  var alt = selected.alt;
  if (0 === alt.length){
    alt = selected.name;
    alt = alt.toUpperCase();
  }

  return('<a href="' + selected.url + '"><img src="' +
    selected.sizes[size].url + '" alt="' + alt + '" width="' +
    selected.sizes[size].width + '" height="' +
    selected.sizes[size].height + '" class="' + align + ' size-' +
    size + ' wp-image-' + selected.id + '" /></a>');
  // console.log(JSON.stringify(selected));
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
